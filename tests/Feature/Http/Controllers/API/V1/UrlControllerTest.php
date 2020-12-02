<?php

namespace Feature\Http\Controllers\API\V1;

use App\Models\Url;
use App\Models\User;
use Database\Factories\UrlFactory;
use Database\Factories\UserFactory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class UrlControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var User $user
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = UserFactory::factoryForModel(User::class)->create();

    }

    /**
     * @test
     */
    public function index()
    {
        $this->withoutMiddleware();
        UrlFactory::factoryForModel(Url::class)->create([
            'user_id' => $this->user->id
        ]);
        $response = $this->actingAs($this->user)->json('GET', 'api/v1/urls')->response;
        $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'data' => [
                [
                    'id',
                    'link',
                    'status',
                    'created_at',
                    'updated_at'
                ]
            ],
            'message'
        ]);
    }

    /**
     * @throws \Throwable
     * @test
     */
    public function store()
    {
        $this->withoutMiddleware();
        $url = UrlFactory::factoryForModel(Url::class)->make([
            'user_id' => $this->user->id
        ]);
        $response = $this->actingAs($this->user)->json('POST', 'api/v1/urls', $url->getAttributes(), ['Accept' => 'application/json'])->response;
        $response->assertStatus(201)
        ->assertJsonStructure([
            'status',
            'data' => [
                'id',
                'link',
                'status',
                'created_at',
                'updated_at'
            ],
            'message'
        ]);
    }
}
