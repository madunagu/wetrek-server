<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Trek;

class TrekTest extends CrudTest
{
    /**
     * The model to use when creating dummy data
     *
     * @var class
     */
    protected $model = Trek::class;
    /**
     * The endpoint to query in the API
     * e.g = /api/v1/<endpoint>
     *
     * @var string
     */
    protected $endpoint = 'trek';
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

    public function testJoinTrek()
    {
        $activity = $this->createPost();
        // Check the API for the new entry
        $response = $this->json('POST', "api/{$this->endpoint}/join");
        // Delete the test shop
        $activity->delete();
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }
}
