<?php

namespace App\Http\Controllers;

use App\Http\Services\InvoiceService;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function __construct(protected InvoiceService $service)
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        [$invoices, $totalBilled, $totalPaid] = $this->service->index();

        return view("/pages/invoices/index")
            ->with([
                "invoices" => $invoices,
                "totalBilled" => $totalBilled,
                "totalPaid" => $totalPaid,
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
            "order_ids" => "required|string",
        ]);

        [$saved, $message, $invoice] = $this->service->store($request);

        return response([
            "status" => $saved,
            "message" => $message,
            "data" => $invoice,
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        [$invoice, $items, $users, $payments, $totalPayments, $balance] = $this->service->show($id);

        $channels = ["MPESA", "BANK", "CASH"];

        // return $invoice;
        return view("/pages/invoices/show")
            ->with([
                "invoice" => $invoice,
                "items" => $items,
                "channels" => $channels,
                "users" => $users,
                "payments" => $payments,
                "totalPayments" => $totalPayments,
                "balance" => $balance,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        [$invoice, $users, $orders, $items] = $this->service->edit($id);

        return view("/pages/invoices/edit")->with([
            "invoice" => $invoice,
			"users" => $users,
			"orders" => $orders,
			"items" => $items
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        [$saved, $message, $invoice] = $this->service->update($request, $id);

        return redirect("/invoices/" . $id . "/edit")->with([
            "success" => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        [$deleted, $message, $invoice] = $this->service->destroy($id);

        return redirect("/invoices")->with([
            "success" => $message,
        ]);
    }
}
