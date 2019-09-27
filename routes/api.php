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

Route::get('marcas', 'MarcaController@index');

Route::prefix('carros')->group(function () {
    Route::get('/', 'CarroController@index');
    Route::get('{carro}', 'CarroController@show');
    Route::post('/', 'CarroController@store');
    Route::put('{carro}', 'CarroController@update');
    Route::delete('{carro}', 'CarroController@destroy');
});
