<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                "address" => 'mỹ đình thành phố hà nội',
                "referral_code" => '456789',
                'referrer_id' => null,
                // 'total_revenue' => '23444',
                // 'wallet' => '234',
                // 'bonus_wallet' => '9999',
                'phone' => '09876543212',
                'role_id' => 1,
                'status' => 'active',
                'name' => 'fullname',
                'email' => 'admin@demo.com',
                'password' => Hash::make('admin'),
            ]
        ];
        foreach ($data as $key => $value) {
            $data_check = User::where('email', $value['email'])->get();
            if (count($data_check) > 0) {
                continue;
            }
            User::create($value);
        }
    }
}
