<?php

use Faker\Generator as Faker;
use App\Address;

$factory->define(Address::class, function (Faker $faker) {
  return [
    'id' => null,
    'description' => $faker->streetAddress,
    'place_id' => 'slsfdk' . rand(1, 20000),
    'reference' => 'slsfdk' . rand(1, 20000),
    'created_at' => $faker->dateTime(),
    'types' => json_encode($faker->words(2)),
    'geometry' => '{}',
    'user_id' => random_int(1, 10),
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
