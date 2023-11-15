<?php

namespace App\Http\Controllers;

use App\Http\Services\PaymentService;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $service)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        [$payments, $total, $users] = $this->service->index($request);

        return view("/pages/payments/index")
            ->with([
                "request" => $request,
                "payments" => $payments,
                "total" => $total,
                "users" => $users,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $channels = $this->service->create();

        return view("pages/payments/create")->with([
			"channels" => $channels
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            "invoice_id" => "string|required",
            "amount" => "string|required",
			"transaction_reference" => "string",
			"payment_channel" => "string",
			"date_received" => "string",
        ]);

        [$saved, $message, $payment] = $this->service->store($request);

        return redirect("/payments")->with(["success" => $message]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
		// 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        [$payment, $channels] = $this->service->edit($id);

        return view("/pages/payments/edit")->with([
            "payment" => $payment,
			"channels" => $channels
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            "invoice_id" => "string",
            "amount" => "string",
			"transaction_reference" => "string",
			"payment_channel" => "string",
			"date_received" => "string",
        ]);

        [$saved, $message, $payment] = $this->service->update($request, $id);

        return redirect("/payments/" . $id . "/edit")->with([
            "success" => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        [$delete, $message, $payment] = $this->service->destroy($id);

        return redirect("/payments")->with([
            "success" => $message,
        ]);
    }
}
