<?php

namespace App\Http\Services;

use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Models\CreditNote;
use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($request)
    {
        $usersQuery = User::where("account_type", "normal");

        if ($request->filled("name")) {
            $usersQuery = $usersQuery
                ->where("name", "LIKE", "%" . $request->name . "%");
        }

        $users = $usersQuery
            ->orderBy("id", "DESC")
            ->paginate(20);

        return UserResource::collection($users);
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
        /*
		* Get User
		*/
        $user = User::findOrFail($id);

        $user = new UserResource($user);

        /*
		* Get Products
		*/
        $products = Product::select("id", "name")
            ->orderBy("id", "DESC")
            ->get();

        /*
		* Get Orders
		*/
        $ordersPaginated = Order::where("user_id", $id)
            ->orderBy("id", "DESC")
            ->paginate(20);

        $orders = OrderResource::collection($ordersPaginated);

        $ordersPendingValue = Order::where("user_id", $id)
            ->where("status", "pending")
            ->sum("total_value");

        $ordersPaidValue = Order::where("user_id", $id)
            ->where("status", "paid")
            ->sum("total_value");

        /*
		* Get Invoices
		*/
        $invoices = Invoice::where("user_id", $id)
            ->orderBy("id", "DESC")
            ->paginate(20);

        $invoicesTotalBilled = Invoice::where("user_id", $id)
            ->sum("amount");

        /*
		* Get Payments
		*/
        $payments = Payment::where("user_id", $id)
            ->orderBy("id", "DESC")
            ->paginate(20);

        $totalPayments = Payment::where("user_id", $id)
            ->sum("amount");

        /*
		* Generated Statements
		*/
        $invoicesForStatements = Invoice::select("id", "amount as debit", "created_at as date")
            ->where("user_id", $id)
            ->get();

        $paymentsForStatements = Payment::select("id", "amount as credit", "date_received as date")
            ->where("user_id", $id)
            ->get();

        $balance = 0;

        $statements = $invoicesForStatements
            ->concat($paymentsForStatements)
            ->sortBy(fn($item) => Carbon::parse($item->date))
            ->values()
            ->map(function ($item) use (&$balance) {

                $item->type = $item->credit ? "Payment" : "Invoice";

                // Calculate balance
                if ($item->credit) {
                    $balance -= $item->credit;
                } else {
                    $balance += $item->debit;
                }

                $item->balance = $balance;

                return $item;
            })
            ->reverse();

        // Get Credit Notes
		$creditNoteQuery = CreditNote::where("user_id", $id);

		$creditNotes = $creditNoteQuery->paginate(20);

        return [
            "user" => $user,
            "products" => $products,
            "ordersPendingValue" => $ordersPendingValue,
            "ordersPaidValue" => $ordersPaidValue,
            "orders" => $orders,
            "invoices" => $invoices,
            "invoicesTotalBilled" => $invoicesTotalBilled,
            "payments" => $payments,
            "totalPayments" => $totalPayments,
            "statements" => $statements,
			"creditNotes" => $creditNotes
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

    public function profileUpdate($request)
    {
        $user = User::find(auth()->user()->id);

        if ($request->hasFile("avatar")) {
            $avatar = $request->file('avatar')->store('public/avatars');
            $avatar = substr($avatar, 7);

            // Delete Avatar if it's not the default one
            if ($user->avatar != '/storage/avatars/male-avatar.png') {

                // Get old avatar and delete it
                $oldAvatar = substr($user->avatar, 9);

                Storage::disk("public")->delete($oldAvatar);
            }

            $user->avatar = $avatar;
        }

        if ($request->filled("name")) {
            $user->name = $request->input("name");
        }

        if ($request->filled("phone")) {
            $user->phone = $request->input("phone");
        }

        $saved = $user->save();

        $message = "Profile updated successfully";

        return [$saved, $message, $user];
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
