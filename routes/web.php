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

$router->get('/','HomeController@index');

$router->get('/carros','CarController@index');
$router->post('/carros','CarController@store');
$router->get('/carros/{id}','CarController@show');
$router->post('/carros/{id}','CarController@update');//PUT não funciona neste framework
$router->delete('/carros/{id}','CarController@delete');

$router->get('/test',function (){

    $carro = new \App\Carro();
    $car = ['ano'=>'210','modelo'=>'Corsa','marca'=>'GM','cor'=>'rosa '];

    $cars = $carro->all();

    dd($carro->all());
    return "";
});