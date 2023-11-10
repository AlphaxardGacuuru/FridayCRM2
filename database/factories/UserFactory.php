<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
			'address' => fake()->address(),
			'registration_number' => Str::random(2) . '-' . rand(1000000, 9999999),
            "created_at" => Carbon::now()->subDay(rand(3, 12)),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Add Alphaxard Account
     *
     * @return static
     */
    public function al()
    {
        return $this->state(fn(array $attributes) => [
            'name' => 'Alphaxard Gacuuru',
            'email' => 'alphaxardgacuuru47@gmail.com',
            'email_verified_at' => now(),
            'phone' => '0700364446',
            'password' => Hash::make('alphaxardgacuuru47@gmail.com'),
            'remember_token' => Str::random(10),
			'account_type' => 'admin'
        ]);
    }
}
