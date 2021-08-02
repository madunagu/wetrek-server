<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Message;
use App\User;

class MessageTest extends CrudTest
{
    protected $model = Message::class;
    protected $endpoint = 'messages';
    protected $states = 'strains';
    protected $store = [];

    public function testIndex()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user, 'api')->json('GET', "api/{$this->endpoint}");
        $response
            ->assertStatus(200)
            ->assertJson([
                'data' => [],
            ])
            ->assertJsonFragment([
                'per_page' => 15,
                'current_page' => 1,
            ])
            ->assertJsonStructure([
                'data' => [],
                'pagination' => [
                    'total',
                    'count',
                    'per_page',
                    'current_page',
                    'total_pages'
                ],
            ]);
    }
}
