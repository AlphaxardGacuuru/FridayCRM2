<?php

use App\Http\Controllers\CreditNoteController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StatementController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::middleware("auth")->group(function () {
    Route::get('/', [DashboardController::class, "index"])->name("dashboard");
    Route::get('/profile', [UserController::class, "profile"])->name("profile");
    Route::put('/profile-update', [UserController::class, "profileUpdate"])->name("profile.update");

    Route::resources([
        "users" => UserController::class,
        "orders" => OrderController::class,
        "products" => ProductController::class,
        "payments" => PaymentController::class,
        "reports" => ReportController::class,
        "statements" => StatementController::class,
        "invoices" => InvoiceController::class,
		"credit-notes" => CreditNoteController::class
    ]);
	
    /*
     * Statement
     */
    Route::get("statement-by-customer-name", [StatementController::class, "byCustomerName"])
        ->name("statements.by.customer.name");
    Route::get("statement-by-status", [StatementController::class, "byStatus"])
        ->name("statements.by.status");
});

Auth::routes(['register' => false]);
