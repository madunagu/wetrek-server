<?php

use Faker\Generator as Faker;
use App\Address;

$factory->define(Address::class, function (Faker $faker) {
  return [
    'id' => null,
    'formatted_address' => $faker->streetAddress,
    'place_id' => random_bytes(28),
    'created_at' => $faker->dateTime(),
    'type'=> $faker->word,
    'plus_code'=>'',
    'geometry_id' => random_int(1,10),
    // 'place_id' => $faker->streetAddress,
    // 'user_id' => 1,
    // 'country' => $faker->country,
    // 'state' => $faker->state,
    // 'city' => $faker->city,
    // 'postal_code' => $faker->postcode,
    // 'name' => $faker->name,
    // 'location_id' => random_int(1, 20),
  ];
});

// $factory->state(Address::class, 'product', [
//     'category' => 'Product',
// ]);
