<?php

namespace App\Http\Services;

use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $getUsers = User::where("account_type", "normal")
            ->orderBy("id", "DESC")
            ->paginate(20);

        return UserResource::collection($getUsers);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($request)
    {
        $user = new User;
        $user->name = $request->input("name");
        $user->email = $request->input("email");
        $user->password = Hash::make($request->input("email"));
        $user->phone = $request->input("phone");
        $user->registration_number = $request->input("registration_number");
        $user->address = $request->input("address");
        $user->kra_pin = $request->input("kra_pin");

        $saved = $user->save();

        $message = $user->name . " created successfully";

        return [$saved, $message, $user];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::findOrFail($id);

        $user = new UserResource($user);

        $products = Product::select("id", "name")
            ->orderBy("id", "DESC")
            ->get();

        $ordersQuery = Order::where("user_id", $id)
            ->orderBy("id", "DESC")
            ->paginate(20);

        $orders = OrderResource::collection($ordersQuery);

        $ordersPendingValue = $ordersQuery
            ->where("status", "pending")
            ->sum("total_value");

        $ordersPaidValue = $ordersQuery
            ->where("status", "paid")
            ->sum("total_value");

        $invoices = Invoice::where("user_id", $id)
            ->orderBy("id", "DESC")
            ->paginate(20);

        $paymentsQuery = Payment::where("user_id", $id);

        $payments = $paymentsQuery
            ->orderBy("id", "DESC")
            ->paginate(20);

        $totalPayments = $paymentsQuery->sum("amount");

        return [
            $user,
            $products,
            $ordersPendingValue,
            $ordersPaidValue,
            $orders,
            $invoices,
			$payments,
			$totalPayments
        ];
    }

    /*
     * Get Data for editing
     */
    public function edit($id)
    {
        $user = User::findOrFail($id);

        return new UserResource($user);
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
        $user = User::findOrFail($id);

        if ($request->filled("name")) {
            $user->name = $request->input("name");
        }

        if ($request->filled("email")) {
            $user->email = $request->input("email");
        }

        if ($request->filled("registration_number")) {
            $user->registration_number = $request->input("registration_number");
        }

        if ($request->filled("address")) {
            $user->address = $request->input("address");
        }

        if ($request->filled("kra_pin")) {
            $user->kra_pin = $request->input("kra_pin");
        }

        if ($request->filled("phone")) {
            $user->phone = $request->input("phone");
        }

        $saved = $user->save();

        $message = $user->name . " updated successfully";

        return [$saved, $message, $user];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $getUser = User::findOrFail($id);

        $deleted = $getUser->delete();

        $message = $getUser->name . " deleted successfully";

        return [$deleted, $message, $getUser];
    }
}
