<?php

namespace App\Http\Controllers;

use App\Http\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(protected OrderService $service)
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
        [$users, $products, $ordersPendingValue, $ordersPaidValue, $orders] = $this->service->index($request);

        return view("pages/orders/index")->with([
			"users" => $users,
			"products" => $products,
            "orders" => $orders,
            "ordersPendingValue" => $ordersPendingValue,
            "ordersPaidValue" => $ordersPaidValue,
			"request" => $request
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        [$users, $products] = $this->service->create();

        return view("pages/orders/create")->with([
            "users" => $users,
            "products" => $products,
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
            "user_id" => "required|string",
            "product_id" => "required|string",
            "date" => "string",
            "vehicle_registration" => "required|string",
            "entry_number" => "required|string|unique:orders",
            "kra_due" => "required|string",
            "kebs_due" => "required|string",
            "other_charges" => "required|string",
        ]);

        [$saved, $message, $order] = $this->service->store($request);

        return redirect("/orders")->with([
            "success" => $message,
        ]);
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
        $order = $this->service->show($id);

        [$users, $products] = $this->service->create();

        return view("/pages/orders/edit")->with([
            "order" => $order,
            "users" => $users,
            "products" => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        [$saved, $message, $order] = $this->service->update($request, $id);

        return redirect("/orders/" . $id . "/edit")->with([
            "success" => $message,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        [$delete, $message, $order] = $this->service->destroy($id);

        return redirect("/orders")->with([
            "success" => $message,
        ]);
    }

    /*
     * Fetch Invoices
     */
    public function invoiceIndex(Request $request)
    {
		// return $request;
        $orders = $this->service->invoiceIndex();

        return view("pages/invoices/index")
            ->with(["orders" => $orders]);
    }

    /*
     * Update Invoice Status
     */
    public function updateInvoiceStatus($id)
    {
        [$saved, $message, $orders] = $this->service->updateInvoiceStatus($id);

        return redirect("/invoices")
            ->with(["success" => $message]);
    }
}
