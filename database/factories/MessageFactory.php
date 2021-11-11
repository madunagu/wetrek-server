<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Message;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    $types = ['trek', 'user'];
    $sender_id = random_int(1, 20);
    $messagable_id = random_int(1, 20);
    return [
        'message' => $faker->sentence,
        'sender_id' => $sender_id,
        'messagable_id' => $messagable_id,
        'messagable_type' => $types[random_int(0, 1)],
        'grouper' => min($sender_id, $messagable_id) . max($sender_id, $messagable_id),
    ];
});


$factory->state(Message::class, 'trek', [
    'messagable_type' => 'trek',
]);
