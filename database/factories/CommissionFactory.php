<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Commission>
 */
class CommissionFactory extends Factory
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
            'commission_rate' => $this->faker->randomFloat(2, 0, 1), // giá trị ngẫu nhiên giữa 0 và 1
            'level' => $this->faker->word,
            'user_id' => $user ? $user->id : User::factory(), // nếu không có user nào trong DB thì tạo user mới
        ];
    }
}
