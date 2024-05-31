<?php

namespace Database\Seeders;

use App\Models\Commission;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;

class CommissionSeeder extends Seeder
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for ($i = 0; $i <= 5; $i++) {
            Commission::create([
                'level' => 'F'.$i + 1,
                'rate' => $this->faker->numberBetween(0, 100),
            ]);
        }
    }
}
