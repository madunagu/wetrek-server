c<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trek;
use Faker\Generator as Faker;

$factory->define(Trek::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(5),
        'start_address_id' => rand(1,20),
        'end_address_id' => rand(1,20),
        'starting_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'duration' => random_int(30, 3000),
        'user_id' => rand(1,5),
    ];
});
