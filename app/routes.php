<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', 'CarroController@index');

Route::get('/carros', 'CarroController@getCarros');

Route::post('/carros', 'CarroController@store');

Route::get('/carros/{id}', 'CarroController@findCarro');

Route::put('/carros/{id}', 'CarroController@update');

Route::delete('/carros/{id}', 'CarroController@destroy');

Route::get('/marcas', 'CarroController@getMarcas');
