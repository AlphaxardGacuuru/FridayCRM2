<?php

namespace App\Http\Services;

use App\Http\Resources\InvoiceResource;
use App\Http\Resources\OrderResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
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
        $invoiceQuery = Invoice::orderBy("id", "DESC");

        $invoices = $invoiceQuery->paginate(20);

        $invoices = InvoiceResource::collection($invoices);

        $totalBilled = $invoiceQuery->sum("amount");

        $totalPaid = Payment::sum("amount");

        return [$invoices, $totalBilled, $totalPaid];
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Confirm invoice status
        $paymentService = new PaymentService;
        // Add invoice Id
        $invoice->invoice_id = $id;
        $invoice->amount = 0;

        $paymentService->updateInvoiceAndOrderStatus($invoice);

        // Fetch again to get new changes
        $invoice = Invoice::findOrFail($id);

        $orders = [];

        foreach ($invoice->order_ids as $orderId) {
            $order = Order::find($orderId);

            array_push($orders, $order);
        }

        $items = OrderResource::collection($orders);

        $invoice = new InvoiceResource($invoice);

        $users = User::where("account_type", "normal")
            ->orderBy("id", "DESC")
            ->get();

        // Get Payments
        $paymentsQuery = Payment::where("invoice_id", $id);

        $payments = $paymentsQuery
            ->orderBy("id", "DESC")
            ->get();

        $totalPayments = $paymentsQuery->sum("amount");

        $balance = $invoice->amount - $totalPayments;

        return [$invoice, $items, $users, $payments, $totalPayments, $balance];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        // Get Order IDs
        $decodedOrderIds = json_decode($request->input("order_ids"));

        $orderIdIsAll = $decodedOrderIds[0] == "all";

        // Get Order Ids from the database
        if ($orderIdIsAll) {
            $orderIds = $this->getAllOrderIds($request);
        } else {
            $orderIds = $decodedOrderIds;
        }

        $userId = Order::find($orderIds[0])->user_id;

        // Get Amount
        $amount = DB::transaction(function () use ($orderIds) {
            return collect($orderIds)->reduce(function ($carry, $orderId) {
                $order = Order::find($orderId);
                // Update status
                $order->status = "invoiced";
                $order->save();

                // Get total value
                $totalValue = $order->total_value;

                return $carry + $totalValue;
            });
        });

        $invoice = new Invoice;
        $invoice->invoice_number = "INV-" . Str::uuid();
        $invoice->user_id = $userId;
        $invoice->order_ids = $orderIds;
        $invoice->amount = $amount;

        $saved = $invoice->save();

        $message = "Invoice created successfully";

        return [$saved, $message, $invoice];
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
        $invoice = Invoice::findOrFail($id);

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
        $invoice = Invoice::findOrFail($id);

        // Change Orders statuses back to pending
        foreach ($invoice->order_ids as $orderId) {
            $exists = Order::find($orderId)->exists();

            if ($exists) {
                Order::findOrFail($orderId)->update(["status" => "pending"]);
            }
        }

        $deleted = $invoice->delete();

        $message = "Invoice deleted successfully";

        return [$deleted, $message, $invoice];
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
            ->paginate(20);

        return InvoiceResource::collection($invoices);
    }

    /*
     * Get All Order IDs
     */
    public function getAllOrderIds($request)
    {
        $orderQuery = Order::select("id")->where("status", "pending");

        if ($request->filled("date")) {
            $orderQuery = $orderQuery->whereDate("date", $request->date);
        }

        if ($request->filled("entry_number")) {
            $orderQuery = $orderQuery->where("entry_number", $request->entry_number);
        }

        if ($request->filled("product_id")) {
            $orderQuery = $orderQuery->where("product_id", $request->product_id);
        }

        if ($request->filled("user_id")) {
            $orderQuery = $orderQuery->where("user_id", $request->user_id);
        }

        return $orderQuery->get()->map(fn($id) => $id->id);
    }
}
