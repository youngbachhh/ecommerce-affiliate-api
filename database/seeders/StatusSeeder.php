<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Status;



class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Status::create([
            'name' => 'active',
            'description' => 'Hoạt động',
        ]);

        Status::create([
            'name' => 'inactive',
            'description' => 'Không hoạt động',
        ]);
    }
}
