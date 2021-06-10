<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'message' => $faker->sentence,
        'sender_id' => random_int(1, 20),
        'reciever_id' => random_int(1, 20),
    ];
});
