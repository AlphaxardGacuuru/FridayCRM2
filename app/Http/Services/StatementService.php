<?php

namespace App\Http\Services;

use App\Http\Resources\StatementResource;
use App\Models\Order;

class StatementService
{
    /*
     * List Statements
     */
    public function index()
    {
        $orders = Order::orderBy("id", "DESC")->paginate(20);

        return StatementResource::collection($orders);
    }

    /*
     * Search by Customer Name
     */
    public function byCustomerName($request)
    {
        $search = $request->input("search");

        $orders = Order::join("users", "users.id", "=", "orders.user_id")
            ->where("users.name", "LIKE", "%$search%")
            ->paginate(20);

        return StatementResource::collection($orders);
    }

    /*
     * Search by Status
     */
    public function byStatus($request)
    {
        $orders = Order::where("status", $request->input("status"))->paginate(20);

        return StatementResource::collection($orders);
    }
}
