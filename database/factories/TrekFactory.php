<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Trek;
use Faker\Generator as Faker;

$factory->define(Trek::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(5),
        'start_address_id' => 1,
        'end_address_id' => 4,
        'starting_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'ending_at' => $faker->dateTime()->format('Y-m-d H:i:s'),
        'group_chat_id'=>1,
        'user_id'=>1,
    ];
});
