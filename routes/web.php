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
    return view('main');
});
$router->get('/carros', 'CarrosController@index');
$router->post('/carros', 'CarrosController@create');
$router->get('/carros/{id}', 'CarrosController@load');
$router->put('/carros/{id}', 'CarrosController@update');
$router->delete('/carros/{id}', 'CarrosController@delete');

