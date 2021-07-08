<?php

use Faker\Generator as Faker;
use App\Address;

$factory->define(Address::class, function (Faker $faker) {
  return [
    'id' => null,
    'address1' => $faker->streetAddress,
    'address2' => $faker->streetAddress,
    'user_id' => 1,
    'country' => $faker->country,
    'state' => $faker->state,
    'city' => $faker->city,
    'postal_code' => $faker->postcode,
    'name' => $faker->name,
    'location_id' => random_int(1, 20),
  ];
});

// $factory->state(Address::class, 'product', [
//     'category' => 'Product',
// ]);
