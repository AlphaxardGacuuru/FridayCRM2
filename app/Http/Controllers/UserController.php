<?php

namespace App\Http\Controllers;

use App\Http\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
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
        $users = $this->service->index();

        return view("pages/users/index")->with([
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
        return view("pages/users/create");
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
            "name" => "required|string",
            "email" => "required|string|unique:users",
            "phone" => "string",
        ]);

        [$saved, $message, $user] = $this->service->store($request);

        return redirect("/users")->with([
            "success" => $message,
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, Request $request)
    {
        $data = $this->service->show($id);

        $statuses = [
            "pending" => "Pending",
            "invoiced" => "Invoiced",
            "partially_paid" => "Partially Paid",
            "paid" => "Paid",
        ];

		// return $data["statements"];
        return view("/pages/users/show")->with([
            "user" => $data["user"],
            "products" => $data["products"],
            "ordersPendingValue" => $data["ordersPendingValue"],
            "ordersPaidValue" => $data["ordersPaidValue"],
            "orders" => $data["orders"],
            "invoices" => $data["invoices"],
			"invoicesTotalBilled" => $data["invoicesTotalBilled"],
            "payments" => $data["payments"],
            "totalPayments" => $data["totalPayments"],
            "statements" => $data["statements"],
            "statuses" => $statuses,
            "request" => $request,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = $this->service->edit($id);

        return view("/pages/users/edit")->with(["user" => $user]);
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
        $this->validate($request, [
            "email" => "nullable|string|unique:users",
        ]);

        [$saved, $message, $user] = $this->service->update($request, $id);

        return redirect("/users/" . $id . "/edit")->with([
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
        [$delete, $message, $user] = $this->service->destroy($id);

        return redirect("/users")->with([
            "success" => $message,
        ]);
    }
}
