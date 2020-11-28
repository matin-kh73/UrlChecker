<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api/v1', 'namespace' => 'API\\V1'], function() use ($router){

    $router->group(['namespace' => 'Auth'], function () use ($router){
        $router->post('/register', 'RegisterController@register');
        $router->post('/login', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
        $router->post('refresh_token','\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
        $router->post('/logout', [
            'middleware' => 'client',
            'uses' => 'LoginController@logout'
        ]);
    });

    $router->group(['middleware' => 'client'], function () use ($router) {

    });
});
