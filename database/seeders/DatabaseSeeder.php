<?php

namespace Database\Seeders;

use App\Models\Url;
use App\Models\User;
use Database\Factories\UrlFactory;
use Database\Factories\UserFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserFactory::factoryForModel(User::class)->create();
        UrlFactory::factoryForModel(Url::class)->create();
        // $this->call('UsersTableSeeder');
    }
}
