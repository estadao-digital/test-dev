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

Route::get('/carros', 'API\CarsController@index');
Route::post('/carros', 'API\CarsController@store');
Route::get('/carros/{id}', 'API\CarsController@show');
Route::put('/carros/{id}', 'API\CarsController@update');
Route::delete('/carros/{id}', 'API\CarsController@destroy');


Route::get('/marcas', 'API\ManufacturerController@index');


