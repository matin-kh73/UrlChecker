<?php


namespace App\Policies;


use App\Models\Url;
use App\Models\User;

class UrlPolicy
{
    public function update(User $user, Url $url)
    {
        return $user->id === $url->user_id;
    }

    public function delete(User $user, Url $url)
    {
        return $user->id === $url->user_id;
    }
}
