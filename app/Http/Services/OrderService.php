<?php

namespace App\Http\Services;

use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;

class OrderService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        $users = User::select("id", "name")
            ->where("account_type", "normal")
            ->orderBy("id", "DESC")
            ->get();

        $products = Product::select("id", "name")
            ->orderBy("id", "DESC")
            ->get();

        [$orders, $ordersPendingValue, $ordersPaidValue] = $this->search($request);

        return [
            $users,
            $products,
            $ordersPendingValue,
            $ordersPaidValue,
            $orders,
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
            ->where("account_type", "normal")
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
        $order = new Order;
        $order->user_id = $request->input("user_id");
        $order->product_id = $request->input("product_id");
        $order->date = $request->input("date");
        $order->vehicle_registration = $request->input("vehicle_registration");
        $order->entry_number = $request->input("entry_number");
        $order->kra_due = $request->input("kra_due");
        $order->kebs_due = $request->input("kebs_due");
        $order->other_charges = $request->input("other_charges");
        $order->total_value = $request->input("total_value");

        $saved = $order->save();

        $message = "Order created successfully";

        return [$saved, $message, $order];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::findOrFail($id);

        return new OrderResource($order);
    }

    /*
     * Get data for Editing
     */
    public function edit()
    {
        $users = User::select("id", "name")
            ->where("account_type", "normal")
            ->orderBy("id", "DESC")
            ->get();

        $products = Product::select("id", "name")
            ->orderBy("id", "DESC")
            ->get();

        return [$users, $products];
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
        $order = Order::findOrFail($id);

        if ($request->filled("user_id")) {
            $order->user_id = $request->input("user_id");
        }

        if ($request->filled("product_id")) {
            $order->product_id = $request->input("product_id");
        }

        if ($request->filled("date")) {
            $order->date = $request->input("date");
        }

        if ($request->filled("vehicle_registration")) {
            $order->vehicle_registration = $request->input("vehicle_registration");
        }

        if ($request->filled("entry_number")) {
            $order->entry_number = $request->input("entry_number");
        }

        if ($request->filled("kra_due")) {
            $order->kra_due = $request->input("kra_due");
        }

        if ($request->filled("kebs_due")) {
            $order->kebs_due = $request->input("kebs_due");
        }

        if ($request->filled("other_charges")) {
            $order->other_charges = $request->input("other_charges");
        }

        if ($request->filled("total_value")) {
            $order->total_value = $request->input("total_value");
        }

        if ($request->filled("status")) {
            $order->status = $request->input("status");
        }

        $saved = $order->save();

        $message = "Order updated successfully";

        return [$saved, $message, $order];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getOrder = Order::findOrFail($id);

        $deleted = $getOrder->delete();

        $message = "Order deleted successfully";

        return [$deleted, $message, $getOrder];
    }

    /*
     * Handle Orders Search
     */
    public function search($request)
    {
        $ordersQuery = new Order;

        if ($request->filled("user_id")) {
            $ordersQuery = $ordersQuery
                ->where("user_id", $request->input("user_id"));
        }

        if ($request->filled("product_id")) {
            $ordersQuery = $ordersQuery
                ->where("product_id", $request->input("product_id"));
        }

        if ($request->filled("entry_number")) {
            $ordersQuery = $ordersQuery
                ->where("entry_number", $request->input("entry_number"));
        }

        if ($request->filled("status")) {
            $ordersQuery = $ordersQuery
                ->where("status", $request->input("status"));
        }

        if ($request->filled("date")) {
            $ordersQuery = $ordersQuery
                ->whereDate("date", $request->input("date"));
        }

        $orders = $ordersQuery
            ->orderBy("date", "DESC")
            ->paginate($request->pagination ? $request->pagination : 50);

        $orders = OrderResource::collection($orders);

        $ordersPendingValue = $ordersQuery
            ->where("status", "pending")
            ->sum("total_value");

        $ordersPaidValue = $ordersQuery
            ->where("status", "paid")
            ->sum("total_value");

        return [
            $orders,
            $ordersPendingValue,
            $ordersPaidValue,
        ];
    }
}
