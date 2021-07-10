<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Traits\AttachJwtToken;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;

abstract class CrudTest extends TestCase
{
    // use AttachJwtToken;
    use RefreshDatabase;

    /**
     * Uses the model factory to generate a fake entry
     *
     * @return class
     */
    public function createPost()
    {
        if ($this->states) {
            //return factory($this->model)->states($this->states)->create();
            return factory($this->model)->create();
        }

        return factory($this->model)->create();
    }

    /**
     * GET /endpoint/
     * Should return 201 with data array
     *
     * @return void
     */
    public function testIndex()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user,'api')->json('GET', "api/{$this->endpoint}");
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => []
            ]);
    }

    /**
     * GET /endpoint/<id>
     * Should return 201 with data array
     *
     * @return void
     */
    public function testShow()
    {
        // Create a test shop with filled out fields
        $activity = $this->createPost();

        $user = factory(User::class)->create();
        // Check the API for the new entry
        $response = $this->actingAs($user,'api')->json('GET', "api/{$this->endpoint}/{$activity->id}");
        // Delete the test shop
        $activity->delete();
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => true
            ]);
    }

    /**
     * POST /endpoint/
     *
     * @return void
     */
    public function testStore()
    {
        $activity = $this->createPost();
        $activity = $activity->toArray();

        $user = factory(User::class)->create();
        /**
         * Pass in any extra data
         */
        if ($this->store) {
            $activity = array_merge($activity, $this->store);
        }
        $response = $this->actingAs($user,'api')->json('POST', "api/{$this->endpoint}/", $activity);
        ($this->model)::destroy($activity['id']);
        $response
            ->assertStatus(201)
            ->assertJson([
                'data' => true
            ]);
    }

    /**
     * DELETE /endpoint/<id>
     * Tests the destroy() method that deletes the shop
     *
     * @return void
     */
    public function testDestroy()
    {
        $user = factory(User::class)->create();
        $activity = $this->createPost();
        $response = $this->actingAs($user,'api')->json('DELETE', "api/{$this->endpoint}/{$activity->id}");
        $response
            ->assertStatus(200);
    }
}
