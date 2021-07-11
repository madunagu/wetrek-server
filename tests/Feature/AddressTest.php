<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Address;
use App\User;
use SebastianBergmann\Environment\Console;

class AddressTest extends CrudTest
{
    /**
     * The model to use when creating dummy data
     *
     * @var class
     */
    protected $model = Address::class;
    /**
     * The endpoint to query in the API
     * e.g = /api/v1/<endpoint>
     *
     * @var string
     */
    protected $endpoint = 'addresses';
    /**
     * Any additional "states" to add to factory
     *
     * @var string
     */
    protected $states = 'strains';
    /**
     * Extra data to pass to POST endpoint
     * aka the (store() method)
     *
     * Must be array (ends up merged with another)
     *
     * @var array
     */
    protected $store = [];

    /**
     * POST /endpoint/
     *
     * @return void
     */
    public function testStore()
    {
        $activity = json_decode(
            '{
                "address_components" : [
                   {
                      "long_name" : "Winnetka",
                      "short_name" : "Winnetka",
                      "types" : [ "locality", "political" ]
                   },
                   {
                      "long_name" : "New Trier",
                      "short_name" : "New Trier",
                      "types" : [ "administrative_area_level_3", "political" ]
                   },
                   {
                      "long_name" : "Cook County",
                      "short_name" : "Cook County",
                      "types" : [ "administrative_area_level_2", "political" ]
                   },
                   {
                      "long_name" : "Illinois",
                      "short_name" : "IL",
                      "types" : [ "administrative_area_level_1", "political" ]
                   },
                   {
                      "long_name" : "United States",
                      "short_name" : "US",
                      "types" : [ "country", "political" ]
                   }
                ],
                     "geometry" : {
                   "bounds" : {
                      "northeast" : {
                         "lat" : 42.1282269,
                         "lng" : -87.7108162
                      },
                      "southwest" : {
                         "lat" : 42.0886089,
                         "lng" : -87.7708629
                      }
                   },
                   "location" : {
                      "lat" : 42.10808340000001,
                      "lng" : -87.735895
                   },
                   "location_type" : "APPROXIMATE",
                   "viewport" : {
                      "northeast" : {
                         "lat" : 42.1282269,
                         "lng" : -87.7108162
                      },
                      "southwest" : {
                         "lat" : 42.0886089,
                         "lng" : -87.7708629
                      }
                   }
                },
                "formatted_address" : "Winnetka, IL, USA",
           
                "place_id" : "ChIJW8Va5TnED4gRY91Ng47qy3Q"
             }',
            true
        );
        // $activity = $activity->toArray();

        $user = factory(User::class)->create();
        /**
         * Pass in any extra data
         */
        if ($this->store) {
            $activity = array_merge($activity, $this->store);
        }
        $response = $this->actingAs($user, 'api')->json('POST', "api/{$this->endpoint}/", $activity);
        // ($this->model)::destroy($activity['id']);
        
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => true
            ]);
    }
}
