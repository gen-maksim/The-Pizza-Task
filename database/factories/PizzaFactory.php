<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Models\Pizza;
use Faker\Generator as Faker;

$factory->define(Pizza::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'description' => $faker->words(7, true),
        'cost' => $faker->numberBetween(10, 100),
        'picture' => $faker->text(20),
    ];
});
