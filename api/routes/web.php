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

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });

// $router->group(['prefix'=>'api/v1'], function() use($router){
//     $router->get('/carros', 'CarController@index');
//     $router->post('/carro', 'CarController@create');
//     $router->get('/carro/{id}', 'CarController@show');
//     $router->put('/carro/{id}', 'CarController@update');
//     $router->delete('/carro/{id}', 'CarController@destroy');
// });

$router->get('/carros', 'CarController@index');
$router->post('/carro', 'CarController@create');
$router->get('/carro/{id}', 'CarController@show');
$router->put('/carro/{id}', 'CarController@update');
$router->delete('/carro/{id}', 'CarController@destroy');
