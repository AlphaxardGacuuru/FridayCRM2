<?php

namespace App\Http\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\Payment;
use App\Models\User;
use Carbon\Carbon;

class ReportService
{
    /*
     * Get All Reports
     */
    public function index($request)
    {
        $orderQuery = Order::select("*", "total_value as amount");

        $invoiceQuery = Invoice::select("id", "user_id", "amount as debit", "created_at as date");

        $paymentQuery = Payment::select("id", "user_id", "amount as credit", "date_received as date");

        // Check if filter is set
        if ($request->input("user_id")) {
            $orderQuery = $orderQuery->where("user_id", $request->input("user_id"));
            $invoiceQuery = $invoiceQuery->where("user_id", $request->input("user_id"));
            $paymentQuery = $paymentQuery->where("user_id", $request->input("user_id"));
        }

        if ($request->filled("daterange")) {
            $dateRange = explode("+-+-", $request->input("daterange"));
            $dateRange = explode(" - ", $dateRange[0]);

            $orderQuery = $orderQuery
                ->whereBetween("date", $dateRange);

            $invoiceQuery = $invoiceQuery
                ->whereBetween("created_at", $dateRange);

            $paymentQuery = $paymentQuery
                ->whereBetween("date_received", $dateRange);
        }

        $ordersTotal = $orderQuery->count();
        $invoicesSum = $invoiceQuery->get()->sum("debit");
        $paymentsSum = $paymentQuery->get()->sum("credit");

        $reports = $orderQuery
            ->orderBy("date", "DESC")
            ->get();

        $orders = $orderQuery
            ->orderBy("date", "DESC")
            ->paginate(50);
        $invoices = $invoiceQuery->get();
        $payments = $paymentQuery->get();

        // $reports = $invoices
        //     ->concat($payments)
        //     ->concat($orders)
        //     ->sortBy(fn($item) => Carbon::parse($item->date))
        //     ->values()
        //     ->map(function ($item) {

        //         if ($item->credit) {
        //             $item->type = "Payment";
        //             $item->total = $item->credit;
        //         } else if ($item->debit) {
        //             $item->type = "Invoice";
        //             $item->total = $item->debit;
        //         } else {
        //             $item->type = "Order";
        //             $item->total = $item->amount;
        //         }

        //         return $item;
        //     })
        //     ->reverse();

        $users = User::select("id", "name")
            ->where("account_type", "normal")
            ->orderBy("id", "DESC")
            ->get();

        return [
            "orders" => $orders,
            "reports" => $reports,
            "users" => $users,
            "ordersTotal" => $ordersTotal,
            "invoicesSum" => $invoicesSum,
            "paymentsSum" => $paymentsSum,
			"dateRange1" => Carbon::parse($dateRange[0])->format("MM/DD/YYYY"),
			"dateRange2" => Carbon::parse($dateRange[1])->format("MM/DD/YYYY")
        ];
    }

}
