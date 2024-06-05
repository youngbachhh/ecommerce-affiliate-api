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
                'referrer_id' => 'RI14933175',
                // 'total_revenue' => '23444',
                // 'wallet' => '234',
                // 'bonus_wallet' => '9999',
                'phone' => '0382252561',
                'role_id' => 1,
                'status' => 1,
                'name' => 'fullname',
                'email' => 'admin@demo.com',
                'password' => Hash::make('123456'),
                'commission_id'=>null,
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
