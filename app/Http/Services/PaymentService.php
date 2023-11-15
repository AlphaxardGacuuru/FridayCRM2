<?php

namespace App\Http\Services;

use App\Http\Resources\PaymentResource;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;

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
            "payments" => $payments,
            "total" => $total,
            "users" => $users,
        ];
    }

    /**
     * Show the get data to prefill form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select("id", "name")
            ->paymentBy("id", "DESC")
            ->get();

        $products = Product::select("id", "name")
            ->paymentBy("id", "DESC")
            ->get();

        return [$users, $products];
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
        $payment->user_id = $request->input("user_id");
        $payment->product_id = $request->input("product_id");
        $payment->date = $request->input("date");
        $payment->vehicle_registration = $request->input("vehicle_registration");
        $payment->entry_number = $request->input("entry_number");
        $payment->kra_due = $request->input("kra_due");
        $payment->kebs_due = $request->input("kebs_due");
        $payment->other_charges = $request->input("other_charges");
        $payment->total_value = $request->input("total_value");

        $saved = $payment->save();

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

        if ($request->filled("user_id")) {
            $payment->user_id = $request->input("user_id");
        }

        if ($request->filled("product_id")) {
            $payment->product_id = $request->input("product_id");
        }

        if ($request->filled("date")) {
            $payment->date = $request->input("date");
        }

        if ($request->filled("vehicle_registration")) {
            $payment->vehicle_registration = $request->input("vehicle_registration");
        }

        if ($request->filled("entry_number")) {
            $payment->entry_number = $request->input("entry_number");
        }

        if ($request->filled("kra_due")) {
            $payment->kra_due = $request->input("kra_due");
        }

        if ($request->filled("kebs_due")) {
            $payment->kebs_due = $request->input("kebs_due");
        }

        if ($request->filled("other_charges")) {
            $payment->other_charges = $request->input("other_charges");
        }

        if ($request->filled("total_value")) {
            $payment->total_value = $request->input("total_value");
        }

        if ($request->filled("status")) {
            $payment->status = $request->input("status");
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

        if ($request) {
            $payments = $paymentsQuery
                ->orderBy("date", "DESC")
                ->paginate(20);
        } else {
            $payments = $paymentsQuery
                ->orderBy("date", "DESC")
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
