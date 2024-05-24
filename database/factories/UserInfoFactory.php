<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserInfo>
 */
class UserInfoFactory extends Factory
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
            'user_id' => $user ? $user->id : User::factory(),
            'img_url' => $this->faker->imageUrl(),
            'idnumber' => $this->faker->numerify('##########'),
            'bank_name' => $this->faker->bank(),
            'bank' => $this->faker->word(),
            'branch' => $this->faker->word(),
        ];
    }
}
