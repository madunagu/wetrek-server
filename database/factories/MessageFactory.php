<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    $types = ['trek', 'user'];
    return [
        'message' => $faker->sentence,
        'sender_id' => random_int(1, 20),
        'messagable_id' => random_int(1, 20),
        'messagable_type' => $types[random_int(0, 1)],
    ];
});
