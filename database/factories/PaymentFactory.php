<?php

namespace Database\Factories;

use App\Models\Orders;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payments>
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
        return [
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'payment_date' => $this->faker->dateTimeThisMonth(),
            'payment_method' => $this->faker->randomElement(['Credit Card', 'PayPal', 'Bank Transfer']),
            'status' => $this->faker->randomElement(['paid', 'pending', 'cancelled', 'failed']),
            'transaction_id' => $this->faker->uuid,
            'order_id' => function () {
                return Orders::factory()->create()->id;
            },
        ];
    }
}
