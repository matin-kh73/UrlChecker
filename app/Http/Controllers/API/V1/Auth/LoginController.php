<?php

namespace App\Http\Controllers\API\V1\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class LoginController extends Controller
{
    /**
     * Logout the user from the application
     *
     * @return mixed
     */
    public function logout()
    {
        try {
            $accessToken = auth()->user()->token();
            $accessToken->revoke();
            return Response::withoutData ('Logout successfully');
        } catch (\Exception $exception) {
            return Response::error('Logout failed, please try again later!');
        }
    }
}
