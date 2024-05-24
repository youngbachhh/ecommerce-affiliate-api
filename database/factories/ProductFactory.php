<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categories;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Products>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $category = Categories::inRandomOrder()->first();

        return [
            'name' => $this->faker->word,
            'thumbnail' => $this->faker->imageUrl(640, 480, 'products', true),
            'price' => $this->faker->randomFloat(2, 1, 1000),
            'product_unit' => $this->faker->word,
            'quantity' => $this->faker->numberBetween(1, 100),
            'description' => $this->faker->sentence,
            'is_featured' => $this->faker->boolean,
            'is_new_arrival' => $this->faker->boolean,
            'ratings' => $this->faker->randomFloat(2, 0, 5),
            'reviews' => $this->faker->numberBetween(0, 100),
            'categories_id' => $category ? $category->id : Categories::factory(),
            'status' => $this->faker->randomElement(['published', 'inactive', 'scheduled']),
        ];
    }
}
