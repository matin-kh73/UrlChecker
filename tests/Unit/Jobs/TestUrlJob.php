<?php

namespace Unit\Jobs;


use App\Models\Url;
use App\Models\User;
use Database\Factories\UrlFactory;
use Database\Factories\UserFactory;
use Laravel\Lumen\Testing\DatabaseMigrations;
use TestCase;

class TestUrlJob extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var Url $url
     */
    private $url;

    /**
     * @var User $user
     */
    private $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = UserFactory::factoryForModel(User::class)->create();
        $this->url = UrlFactory::factoryForModel(Url::class)->create([
            'user_id' => $this->user->id,
        ]);
    }

    /**
     * @test
     */
    public function checking_a_valid_url_with_sending_a_request()
    {
        $job = new \App\Jobs\TestUrlJob($this->url);
        app()->call([$job, 'handle']);

        $this->seeInDatabase('urls', [
            'link' => $this->url->link,
            'user_id' => $this->user->id
        ]);
    }
}
