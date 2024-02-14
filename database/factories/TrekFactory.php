<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trek;
use Faker\Generator as Faker;

$factory->define(Trek::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'start_address_id' => rand(1, 20),
        'end_address_id' => rand(1, 20),
        "latitude" => 6.452363699999999,
        "longitude" => 3.252261,
        'direction_id' => rand(0, 1),
        'starting_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'duration' => random_int(30, 3000),
        'user_id' => rand(1, 5),
        'description' => $faker->sentence,
    ];
});
