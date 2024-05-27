<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
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
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'password' => bcrypt('password'), // Mật khẩu mặc định có thể là 'password'
            'referral_code' => Str::random(8),
            'referrer_id' => null,
            'status' => $this->faker->randomElement(['active', 'inactive', 'pending']),
            'total_revenue' => $this->faker->randomFloat(2, 0, 1000),
            'wallet' => $this->faker->randomFloat(2, 0, 100),
            'bonus_wallet' => $this->faker->randomFloat(2, 0, 50),
            'role_id' => 1, // Giả sử role_id mặc định là 1
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
