<?php

use Faker\Generator as Faker;
use App\Address;

$factory->define(Address::class, function (Faker $faker) {
  return [
    'id' => null,
    'formatted_address' => $faker->streetAddress,
    'place_id' => 'slsfdk' . rand(1, 20000),
    'created_at' => $faker->dateTime(),
    'types' => json_encode($faker->words(2)),
    'plus_code' => '{}',
    'geometry' => '{}',
    'address_components' => '[
      {
         "long_name" : "Winnetka",
         "short_name" : "Winnetka",
         "types" : [ "locality", "political" ]
      },
      {
         "long_name" : "New Trier",
         "short_name" : "New Trier",
         "types" : [ "administrative_area_level_3", "political" ]
      }]',
    'lat' => $faker->latitude,
    'lng' => $faker->longitude,
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
