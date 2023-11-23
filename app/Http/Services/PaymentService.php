<?php

namespace App\Http\Services;

use App\Http\Resources\PaymentResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class PaymentService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        $users = User::orderBy("id", "DESC")
            ->where("account_type", "normal")
            ->get();

        [$payments, $total] = $this->search($request);

        return [
            $payments,
            $total,
            $users,
        ];
    }

    /**
     * Show the get data to prefill form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = ["MPESA", "VISA", "MASTERCARD", "CASH"];

        return $channels;
    }

    /*
     * Get Edit data
     */
    public function edit($id)
    {
        $payment = Payment::findOrFail($id);

        $users = User::where("account_type", "normal")
            ->orderBy("id", "DESC")
            ->get();

        $channels = ["MPESA", "VISA", "MASTERCARD", "CASH"];

        return [$payment, $users, $channels];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $payment = new Payment;
        $payment->invoice_id = $request->input("invoice_id");
        $payment->user_id = Invoice::find($request->input("invoice_id"))->user->id;
        $payment->amount = $request->input("amount");
        $payment->transaction_reference = $request->input("transaction_reference");
        $payment->payment_channel = $request->input("payment_channel");
        $payment->date_received = $request->input("date_received");

        $saved = DB::transaction(function () use ($payment, $request) {
            $this->updateInvoiceAndOrderStatus($request);

            $saved = $payment->save();

            return $saved;
        });

        $message = "Payment created successfully";

        return [$saved, $message, $payment];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $payment = Payment::findOrFail($id);

        return new PaymentResource($payment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($request, $id)
    {
        $payment = Payment::findOrFail($id);

        if ($request->filled("invoice_id")) {
            $payment->invoice_id = $request->input("invoice_id");
        }

        if ($request->filled("user_id")) {
            $payment->user_id = Invoice::find($request->input("invoice_id"))->user->id;
        }

        if ($request->filled("amount")) {
            $payment->amount = $request->input("amount");
        }

        if ($request->filled("transaction_reference")) {
            $payment->transaction_reference = $request->input("transaction_reference");
        }

        if ($request->filled("payment_channel")) {
            $payment->payment_channel = $request->input("payment_channel");
        }

        if ($request->filled("date_received")) {
            $payment->date_received = $request->input("date_received");
        }

        $saved = $payment->save();

        if ($request->filled("amount")) {
            // Populate request with invoice_id and amount
            $request->invoice_id = $payment->invoice_id;
            $request->amount = $request->amount - $payment->amount;

            $this->updateInvoiceAndOrderStatus($request);
        }

        $message = "Payment updated successfully";

        return [$saved, $message, $payment];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $payment = Payment::findOrFail($id);

        $deleted = $payment->delete();

        // Update amount for updating status
        $payment->amount = 0;

        $this->updateInvoiceAndOrderStatus($payment);

        $message = "Payment deleted successfully";

        return [$deleted, $message, $payment];
    }

    /*
     * Handle Search
     */
    public function search($request)
    {
        $paymentsQuery = new Payment;

        if ($request->filled("date_received")) {
            $paymentsQuery = $paymentsQuery
                ->whereDate("date_received", $request->input("date_received"));
        }

        $payments = $paymentsQuery
            ->orderBy("created_at", "DESC")
            ->paginate(20);

        $payments = PaymentResource::collection($payments);

        $total = $paymentsQuery->sum("amount");

        return [
            $payments,
            number_format($total),
        ];
    }

    /*
     * Handle Invoice Status Change
     */
    public function updateInvoiceAndOrderStatus($request)
    {
        $balance = Payment::where("invoice_id", $request->invoice_id)
            ->sum("amount");

        $amount = $balance + $request->amount;

        $invoice = Invoice::find($request->invoice_id);

        // Check if amount is enough
        if ($amount == 0) {
            $status = "invoiced";
        } else if ($amount < $invoice->amount) {
            $status = "partially_paid";
        } else if ($amount == $invoice->amount) {
            $status = "paid";
        } else {
			$status = "over_paid";
        }

        // Update Order Statuses
        Order::whereIn('id', $invoice->order_ids)
            ->update(["status" => $status]);

        $invoice->status = $status == "invoiced" ? "not_paid" : $status;

        return $invoice->save();
    }
}
