<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Products;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Discounts>
 */
class DiscountFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $product = Products::inRandomOrder()->first();

        return [
            'discount_value' => $this->faker->randomFloat(2, 0, 100), // giá trị ngẫu nhiên giữa 0 và 100
            'product_id' => $product ? $product->id : Products::factory(),
        ];
    }
}
