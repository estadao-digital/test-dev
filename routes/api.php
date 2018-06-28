<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('carros', 'CarroController@index');
Route::post('carros', 'CarroController@store');
Route::get('carros/{id}', 'CarroController@show');
Route::put('carros/{id}', 'CarroController@update');
Route::delete('carros/{id}', 'CarroController@destroy');
