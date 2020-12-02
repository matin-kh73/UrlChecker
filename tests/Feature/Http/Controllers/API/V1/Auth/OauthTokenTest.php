<?php

namespace Feature\Http\Controllers\API\V1\Auth;

use App\Models\User;
use Database\Factories\UserFactory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use TestCase;

class OauthTokenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var User $user
     */
    private $user;

    /**
     * @var Client $client
     */
    private $client;

    private $clientRepository;

    public function setUp(): void
    {
        parent::setUp();

        $this->clientRepository = $this->app->make(ClientRepository::class);

        $this->user = UserFactory::factoryForModel(User::class)->create();

        $this->client = $this->clientRepository->createPasswordGrantClient(
            null, 'Test Password Grant Client', ''
        );
    }


    /**
     * test oauth token for get access token with passport
     * @test
     */
    public function get_access_token_with_passport()
    {
        $body = [
            'username' => $this->user->email,
            'password' => '123',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'grant_type' => 'password',
            'scope' => '*',
        ];

        $response = $this->json('POST', '/api/v1/login', $body, ['Accept' => 'application/json'])->response;
        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'refresh_token',
                'expires_in',
                'token_type',
            ]);
    }

    /**
     * test oauth token for get access token with refresh token
     * @test
     */
    public function get_refresh_token_with_passport()
    {
        $body = [
            'username' => $this->user->email,
            'password' => '123',
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'grant_type' => 'password',
        ];

        $refresh_token = $this->json('POST',
            'api/v1/login',
            $body,
            ['Accept' => 'application/json']
        )->response->decodeResponseJson()->json('refresh_token');

        $body = [
            'refresh_token' => $refresh_token,
            'client_id' => $this->client->id,
            'client_secret' => $this->client->secret,
            'grant_type' => 'refresh_token',
        ];

        $response = $this->json('POST', 'api/v1/refresh_token', $body, ['Accept' => 'application/json'])->response;

        $response->assertStatus(200)
            ->assertJsonStructure([
                'access_token',
                'refresh_token',
                'expires_in',
                'token_type',
            ]);
    }
}

