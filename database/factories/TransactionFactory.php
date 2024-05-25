<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Transactions>
 */
class TransactionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $user = User::inRandomOrder()->first();
        return [
            'wallet_type' => $this->faker->randomElement(['main', 'bonus']),
            'amount' => $this->faker->numberBetween(100, 10000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'failed']),
            'user_id' => $user ? $user->id : User::factory(),
        ];
    }
}
