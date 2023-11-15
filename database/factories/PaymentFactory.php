<?php

namespace Database\Factories;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
		$invoice = Invoice::all()->random();

		$channels = ["MPESA", "VISA", "MASTERCARD", "CASH"];

        return [
            "invoice_id" => $invoice->id,
            "amount" => rand(1, 99) * 1000,
            "payment_channel" => $channels[rand(0, 3)],
			"transaction_reference" => Str::random(4) . '-' . rand(100000, 999999),
			"date_received" => Carbon::now()->subDays(rand(1, 10))
        ];
    }
}
