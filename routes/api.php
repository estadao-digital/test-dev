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

Route::get('/', 'Api\\InfoController@default')
    ->name('api');

Route::prefix('carros')->group(function () {
    Route::get('/', 'Api\\CarController@index')
        ->name('api.cars.get');
    Route::post('/', 'Api\\CarController@create')
        ->name('api.car.post');
    Route::get('/{id}', 'Api\\CarController@read')
        ->name('api.car.get');
    Route::put('/{id}', 'Api\\CarController@update')
        ->name('api.car.put');
    Route::delete('/{id}', 'Api\\CarController@delete')
        ->name('api.car.delete');
});