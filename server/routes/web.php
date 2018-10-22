<?php

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

$router->get('marcas', 'BrandController@index');

$router->group(['prefix' => 'carros'], function () use ($router) {
    $router->get('/', 'CarController@index');
    $router->get('/{id}', 'CarController@show');
    $router->post('/', 'CarController@store');
    $router->put('/{id}', 'CarController@update');
    $router->delete('/{id}', 'CarController@destroy');
});
