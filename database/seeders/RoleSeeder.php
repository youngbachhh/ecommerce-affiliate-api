<?php

namespace Database\Seeders;

use App\Models\RoleModel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            "Admin", // admin
            "Affiliate Marketer", // Người tiếp thị liên kết
            "User", // Người dùng
        ];
        foreach ($data as $key => $value) {
            $data_check = RoleModel::where('name', $value)->get();
            if (count($data_check) > 0) {
                continue;
            }
            RoleModel::create([
                'name' => $value
            ]);
        }
    }
}
