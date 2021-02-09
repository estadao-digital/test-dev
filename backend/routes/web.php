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


$router->group(['prefix' => 'carros'], function () use ($router) {
    // - `/carros` - [POST] deve cadastrar um novo carro.
    $router->post('/', 'CarController@createCar');
    
    // - `/carros` - [GET] deve retornar todos os carros cadastrados. 
    $router->get('/', 'CarController@index');

    // - `/carros/{id}`[GET] deve retornar o carro com ID especificado.
    $router->get('/{id}', 'CarController@getCar');

    // - `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
    $router->put('/{id}', 'CarController@updateCar');

    // - `/carros/{id}`[DELETE] deve apagar o carro com ID especificado.
    $router->delete('/{id}', 'CarController@deleteCar');
});
