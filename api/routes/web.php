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
    return "Api Estadao - Teste";
});

// Lista Carros
$router->get('carros', 'carroController@list');
// Cadastra um novo carro
$router->post('carros', 'carroController@insert');
// Pega um carro
$router->get('carros/{id}', 'carroController@get');
// Alterar carro
$router->put('carros/{id}', 'carroController@update');
// Delete carro
$router->delete('carros/{id}', 'carroController@delete');

