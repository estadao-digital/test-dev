<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

//Entrada de Propostas
Route::group(['prefix' => 'carros'], function () {

    Route::get('/', 'Carro\CarroController@index');
    Route::get('/show/{id}', 'Carro\CarroController@show');

    Route::post('/create', 'Carro\CarroController@create');
    Route::post('/update/{id}', 'Carro\CarroController@update');
    Route::post('/destroy/{id}', 'Carro\CarroController@update');

});





