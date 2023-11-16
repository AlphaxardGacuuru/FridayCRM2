<?php

namespace App\Http\Services;

use App\Http\Resources\PaymentResource;
use App\Models\Invoice;
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
        $users = User::orderBy("id", "DESC")->get();

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
        $payment = Payment::find($id);

        $channels = ["MPESA", "VISA", "MASTERCARD", "CASH"];

        return [$payment, $channels];
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
        $payment->amount = $request->input("amount");
        $payment->transaction_reference = $request->input("transaction_reference");
        $payment->payment_channel = $request->input("payment_channel");
        $payment->date_received = $request->input("date_received");

        $saved = DB::transaction(function ($payment) use ($request) {
            $saved = $payment->save();

            $invoice = Order::find($request->invoice_id);
            $invoice->status = $request->amount < $invoice->amount ? "partially_paid" : "paid";
            $invoice->save();

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
        $payment = Payment::find($id);

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
        $payment = Payment::find($id);

        if ($request->filled("invoice_id")) {
            $payment->invoice_id = $request->input("invoice_id");
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
        $getPayment = Payment::find($id);

        $deleted = $getPayment->delete();

        $message = "Payment deleted successfully";

        return [$deleted, $message, $getPayment];
    }

    /*
     * Handle Search
     */
    public function search($request)
    {
        $paymentsQuery = new Payment;

        if ($request->filled("user_id")) {
            $paymentsQuery = $paymentsQuery
                ->where("user_id", $request->input("user_id"));
        }

        if ($request->filled("date_received")) {
            $paymentsQuery = $paymentsQuery
                ->whereDate("date_received", $request->input("date_received"));
        }

        if ($request) {
            $payments = $paymentsQuery
                ->orderBy("created_at", "DESC")
                ->paginate(20);
        } else {
            $payments = $paymentsQuery
                ->orderBy("created_at", "DESC")
                ->paginate(20);
        }

        $payments = PaymentResource::collection($payments);

        $total = $paymentsQuery->sum("amount");

        return [
            $payments,
            number_format($total),
        ];
    }
}
