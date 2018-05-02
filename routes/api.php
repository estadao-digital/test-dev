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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('carros/', 'API\CarrosController@getCarros');
Route::post('carros/',  'API\CarrosController@insertCarro');
Route::get('carros/{id}', 'API\CarrosController@getCarro');
Route::put('carros/{id}', 'API\CarrosController@updateCarro');
Route::delete('carros/{id}', 'API\CarrosController@deleteCarro');
Route::get('marcas/', 'API\CarrosController@getMarcas');
