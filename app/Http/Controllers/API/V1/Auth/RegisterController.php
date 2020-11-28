<?php

namespace App\Http\Controllers\API\V1\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class RegisterController extends Controller
{
    /**
     * Register a new user in the database
     *
     * @param RegisterRequest $request
     * @return mixed
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::query()->create($request->validated());
            return Response::created($user, 'User created successfully');
        } catch (\Exception $exception) {
            throw new HttpResponseException(Response::error('User can not be created. please try again later!'), $exception->getCode());
        }
    }
}
