<?php

use App\Models\Pizza;
use Carbon\Carbon;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PizzaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        for ($i = 1; $i <= 8; $i++) {
            Pizza::create([
                'name' => ($i < 8 ? Carbon::now()->addDays($i)->englishDayOfWeek : 'Special') . ' pizza',
                'description' => $faker->realText(100),
                'cost' => $faker->numberBetween(3, 12),
                'picture' => $i,
            ]);
        }
    }
}
