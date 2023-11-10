<?php

namespace App\Http\Services;

use App\Http\Resources\InvoiceItemResource;
use App\Http\Resources\InvoiceResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Str;

class InvoiceService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoice::orderBy("id", "DESC")->paginate(10);

        return InvoiceResource::collection($invoices);
    }

    /**
     * Show the get data to prefill form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::select("id", "name")
            ->orderBy("id", "DESC")
            ->get();

        $products = Product::select("id", "name")
            ->orderBy("id", "DESC")
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
        // Get User ID
        $orderIds = json_decode($request->input("order_ids"));

        $userId = Order::find($orderIds[0])->user_id;

        // Get Amount
        $amount = collect($orderIds)->reduce(function ($carry, $orderId) {
            $totalValue = Order::find($orderId)->total_value;

            return $carry + $totalValue;
        });

		$items = collect($orderIds)->map(function ($orderId) {
			$order = Order::find($orderId);

			return new InvoiceItemResource($order);
		});

        $invoice = new Invoice;
        $invoice->invoice_number = "INV-" . Str::uuid();
        $invoice->user_id = $userId;
        $invoice->order_ids = $orderIds;
        $invoice->items = $items;
        $invoice->amount = $amount;

        $saved = $invoice->save();

        $message = "Invoice created successfully";

        return [$saved, $message, $invoice];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::find($id);

        return new InvoiceResource($invoice);
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
        $invoice = Invoice::find($id);

        if ($request->filled("user_id")) {
            $invoice->user_id = $request->input("user_id");
        }

        if ($request->filled("product_id")) {
            $invoice->product_id = $request->input("product_id");
        }

        if ($request->filled("date")) {
            $invoice->date = $request->input("date");
        }

        if ($request->filled("vehicle_registration")) {
            $invoice->vehicle_registration = $request->input("vehicle_registration");
        }

        if ($request->filled("entry_number")) {
            $invoice->entry_number = $request->input("entry_number");
        }

        if ($request->filled("kra_due")) {
            $invoice->kra_due = $request->input("kra_due");
        }

        if ($request->filled("kebs_due")) {
            $invoice->kebs_due = $request->input("kebs_due");
        }

        if ($request->filled("other_charges")) {
            $invoice->other_charges = $request->input("other_charges");
        }

        if ($request->filled("total_value")) {
            $invoice->total_value = $request->input("total_value");
        }

        if ($request->filled("status")) {
            $invoice->status = $request->input("status");
        }

        $saved = $invoice->save();

        $message = "Invoice updated successfully";

        return [$saved, $message, $invoice];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getInvoice = Invoice::find($id);

        $deleted = $getInvoice->delete();

        $message = "Invoice deleted successfully";

        return [$deleted, $message, $getInvoice];
    }

    /*
     * Get Invoices
     */
    public function invoiceIndex()
    {
        $invoices = Invoice::where("status", "pending")
            ->orderBy("id", "DESC")
            ->paginate(10);

        return InvoiceResource::collection($invoices);
    }

    /*
     * Handle Invoices Search
     */
    public function invoices($request)
    {
        $invoicesQuery = new Invoice;

        if ($request->filled("user_id")) {
            $invoicesQuery = $invoicesQuery->where("user_id", $request->input("user_id"));
        }

        if ($request->filled("product_id")) {
            $invoicesQuery = $invoicesQuery->where("product_id", $request->input("product_id"));
        }

        if ($request->filled("entry_number")) {
            $invoicesQuery = $invoicesQuery->where("entry_number", $request->input("entry_number"));
        }

        if ($request->filled("status")) {
            $invoicesQuery = $invoicesQuery->where("status", $request->input("status"));
        }

        if ($request->filled("date")) {
            $invoicesQuery = $invoicesQuery->whereDate("date", $request->input("date"));
        }

        $invoices = $invoicesQuery
            ->orderBy("date", "DESC")
            ->paginate(10);

        return InvoiceResource::collection($invoices);
    }
}