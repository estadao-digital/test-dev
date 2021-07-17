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

$router->get('/foo', function () {
    return 'foo!';
});

$router->group(['prefix' => 'carros'],function() use ($router){
    $router->get('/', 'CarroController@index');
    $router->post('/','CarroController@store');
    $router->put('/{id}','CarroController@update');
    $router->delete('/{id}','CarroController@delete');
});

$router->group(['prefix' => 'marcas'],function() use ($router){
    $router->get('/', 'MarcaController@index');
});

