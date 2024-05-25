<?php

namespace Database\Factories;

use App\Models\Orders;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ship>
 */
class ShipFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'status' => $this->faker->randomElement(['delivered', 'out for delivery', 'ready to pickup', 'dispatched']),
            'begin_time' => $this->faker->dateTimeThisMonth(),
            'expected_arrive' => $this->faker->dateTimeThisMonth(),
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'order_id' => function () {
                return Orders::factory()->create()->id;
            },
        ];
    }
}
