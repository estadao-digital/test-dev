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
    return view('index');
});

$router->get('/carros',         '\App\Http\Controllers\CarroController@carregar_carros');
$router->get('/carro/{id}',     '\App\Http\Controllers\CarroController@carregar_carro');
$router->post('/carro',         '\App\Http\Controllers\CarroController@adicionar_carro');
$router->put('/carro/{id}',     '\App\Http\Controllers\CarroController@editar_carro');
$router->delete('/carro/{id}',  '\App\Http\Controllers\CarroController@deletar_carro');
