<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Cart;
use App\Models\Categories;
use App\Models\Commission;
use App\Models\Discounts;
use App\Models\OrderDetail;
use App\Models\Orders;
use App\Models\Products;
use App\Models\Role;
use App\Models\Ship;
use App\Models\User;
use App\Models\Payments;
use App\Models\RolePermission;
use App\Models\Transactions;
use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(15)->create();
        // Role::factory(15)->create();
        // Categories::factory(15)->create();
        // Products::factory(15)->create();
        // Orders::factory(15)->create();
        // OrderDetail::factory(15)->create();
        // Payments::factory(15)->create();
        // Ship::factory(15)->create();
        // Commission::factory(15)->create();
        // RolePermission::factory(15)->create();
        // Transactions::factory(15)->create();
        // UserInfo::factory(15)->create();
        // Discounts::factory(15)->create();
        // Cart::factory(15)->create();

        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CommissionSeeder::class,
            WalletSeeder::class
        ]);
    }
}
