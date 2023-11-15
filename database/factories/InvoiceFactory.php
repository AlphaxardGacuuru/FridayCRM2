<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
		$order = Order::all()->random();

		$user = User::all()->random();

        return [
            "invoice_number" => "",
			"user_id" => $user->id,
			"order_ids" => [$order->id],
			"amount" => fake()->numberBetween(10000, 100000),
        ];
    }
}
