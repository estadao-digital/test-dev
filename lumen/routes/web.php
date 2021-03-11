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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/carros/{id}', ['uses' => '\App\Http\Controllers\CarController@get']);
$router->get('/carros', ['uses' => '\App\Http\Controllers\CarController@getAll']);
$router->post('/carros', ['uses' => '\App\Http\Controllers\CarController@store']);
$router->put('/carros/{id}', ['uses' => '\App\Http\Controllers\CarController@update']);
$router->delete('/carros/{id}', ['uses' => '\App\Http\Controllers\CarController@destroy']);
