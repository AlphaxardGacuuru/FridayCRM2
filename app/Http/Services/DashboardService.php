<?php

namespace App\Http\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function index()
    {
        return [
            "users" => $this->users(),
            "orders" => $this->orders(),
            "revenue" => $this->revenue(),
            "products" => $this->products(),
            "revenueLastWeek" => $this->revenueLastWeek(),
            "productsLastWeek" => $this->productsLastWeek(),
        ];
    }

    /*
     * Get Users Data
     */
    public function users()
    {
        $total = User::where("account_type", "normal")->count();

        $carbonYesterday = now()->subDay();

        $yesterday = User::whereDate("created_at", $carbonYesterday)->count();

        $carbonToday = Carbon::today()->toDateString();

        $today = User::whereDate("created_at", $carbonToday)->count();

        // Get Users By Day
        $startDate = Carbon::now()->subWeek()->startOfWeek();
        $endDate = Carbon::now()->subWeek()->endOfWeek();

        $getUsersLastWeek = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(users.created_at)'))
            ->get()
            ->map(function ($item) {
                return $item->count;
            });

        return [
            "total" => $total,
            "growth" => $this->growth($yesterday, $today),
            "lastWeek" => $getUsersLastWeek,
        ];
    }

    /*
     * Get Orders
     */
    public function orders()
    {
        $total = Order::count();

        $orders = Order::orderBy("date", "DESC")->paginate(20);

        $carbonYesterday = now()->subDay();

        $yesterday = Order::whereDate("created_at", $carbonYesterday)->count();

        $carbonToday = Carbon::today()->toDateString();

        $today = Order::whereDate("created_at", $carbonToday)->count();

        return [
            "total" => $total,
            "growth" => $this->growth($yesterday, $today),
            "list" => $orders,
            "lastMonth" => $this->ordersLastMonth(),
        ];
    }

    /*
     * Get Revenue
     */
    public function revenue()
    {
        $total = Order::sum('total_value');

        $carbonYesterday = now()->subDay();

        $yesterday = Order::whereDate("date", $carbonYesterday)->sum("total_value");

        $carbonToday = Carbon::today()->toDateString();

        $today = Order::whereDate("date", $carbonToday)->sum("total_value");

        $growth = $this->growth($yesterday, $today);

        return [
            "total" => number_format($total),
            "growth" => number_format($growth),
        ];
    }

    /*
     * Get Products
     */
    public function products()
    {
        $total = Product::count();

        $topProducts = Product::withCount('orders')
            ->groupBy('products.id', 'products.name', 'products.created_at', 'products.updated_at')
            ->orderBy('orders_count', 'desc')
            ->get();

        $carbonYesterday = now()->subDay();

        $yesterday = Product::whereDate("created_at", $carbonYesterday)->count();

        $carbonToday = Carbon::today()->toDateString();

        $today = Product::whereDate("created_at", $carbonToday)->count();

        return [
            "total" => $total,
            "top" => $topProducts,
            "growth" => $this->growth($yesterday, $today),
        ];
    }

    /*
     * Get Orders Last Week
     */
    public function ordersLastMonth()
    {
        // Get Ordes By Day
        $startDate = Carbon::now()->startOfMonth();
        $endDate = Carbon::now()->endOfMonth();

        $getOrdersLastWeek = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(orders.created_at)'))
            ->get()
            ->map(function ($item) {
                return [
                    "day" => Carbon::parse($item->date)->day,
                    "count" => $item->count,
                ];
            });

        $labels = $getOrdersLastWeek->map(fn($item) => $item["day"]);
        $data = $getOrdersLastWeek->map(fn($item) => $item["count"]);

        return [
            "getOrdersLastWeek" => $getOrdersLastWeek,
            "labels" => $labels,
            "data" => $data,
        ];
    }

    /*
     * Get Revenue Last Week
     */
    public function revenueLastWeek()
    {

        // Get Revenue By Day
        $startDate = Carbon::now()->subWeek()->startOfWeek();
        $endDate = Carbon::now()->subWeek()->endOfWeek();

        $getRevenueLastWeek = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_value) as sum'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(orders.created_at)'))
            ->get()
            ->map(function ($item) {
                return [
                    "day" => Carbon::parse($item->date)->dayName,
                    "sum" => $item->sum,
                ];
            });

        $revenueLastWeekLabels = $getRevenueLastWeek->map(fn($item) => $item["day"]);
        $revenueLastWeekData = $getRevenueLastWeek->map(fn($item) => $item["sum"]);

        return [
            "labels" => $revenueLastWeekLabels,
            "data" => $revenueLastWeekData,
        ];
    }

    /*
     * Get Revenue Last Week
     */
    public function productsLastWeek()
    {
        // Get Revenue By Day
        $startDate = Carbon::now()->subWeek()->startOfWeek();
        $endDate = Carbon::now()->subWeek()->endOfWeek();

        $getRevenueLastWeek = Order::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_value) as sum'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy(DB::raw('DATE(orders.created_at)'))
            ->get()
            ->map(function ($item) {
                return [
                    "day" => Carbon::parse($item->date)->dayName,
                    "sum" => $item->sum,
                ];
            });

        $revenueLastWeekLabels = $getRevenueLastWeek->map(fn($item) => $item["day"]);
        $revenueLastWeekData = $getRevenueLastWeek->map(fn($item) => $item["sum"]);

        return [
            "labels" => $revenueLastWeekLabels,
            "data" => $revenueLastWeekData,
        ];
    }

    // Calculate Growth
    public function growth($yesterday, $today)
    {
        // Resolve for Division by Zero
        if ($yesterday == 0) {
            $growth = $today == 0 ? 0 : $today * 100;
        } else if ($today == 0) {
            $growth = $yesterday == 0 ? 0 : $yesterday * -100;
        } else {
            $growth = $today / $yesterday * 100;
        }

        return $growth;
        // return number_format($growth);
    }
}
