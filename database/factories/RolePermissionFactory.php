<?php

namespace Database\Factories;

use App\Models\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RolePermission>
 */
class RolePermissionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        // Lấy tất cả các role từ cơ sở dữ liệu
        $roles = Role::all();

        // Lấy một role ngẫu nhiên từ danh sách roles
        $randomRole = $roles->random();

        return [
            'gurd_name' => $this->faker->word,
            'role_id' => $randomRole->id
        ];
    }
}
