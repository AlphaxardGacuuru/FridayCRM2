<?php

namespace Database\Factories;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

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
		$user = User::all()->random();

		$types = ["MPESA", "VISA", "Mastercard"];

        return [
            "user_id" => $user->id,
            "amount" => rand(1, 99) * 1000,
            "type" => $types[rand(0, 2)],
			"created_at" => Carbon::now()->subDays(rand(1, 10))
        ];
    }
}
