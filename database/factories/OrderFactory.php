<?php

namespace Database\Factories;

use App\Models\Products;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Orders>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'total_money' => $this->faker->numberBetween(100, 1000),
            'status' => $this->faker->randomElement(['pending', 'completed', 'refunded', 'failed']),
            'note' => $this->faker->sentence,
            'product_id' => function () {
                return Products::factory()->create()->id;
            },
            'user_id' => function () {
                return \App\Models\User::factory()->create()->id;
            },
        ];
    }
}
