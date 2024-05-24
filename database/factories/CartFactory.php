<?php

namespace Database\Factories;

use App\Models\Products;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cart>
 */
class CartFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => function () {
                return Products::factory()->create()->id;
            },
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'amount' => $this->faker->numberBetween(1, 10), // Số lượng sản phẩm trong giỏ hàng
        ];
    }
}
