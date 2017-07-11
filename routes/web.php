<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', ['uses' => 'HomeController@index']);

Route::group(['prefix' => 'api', 'as' => 'api.'], function () {
    Route::get('/', ['as' => 'get', 'uses' => 'ApiController@show']);
    Route::get('carros/{id?}', ['as' => 'get', 'uses' => 'ApiController@show']);
    Route::post('carros', ['as' => 'store', 'uses' => 'ApiController@store']);
    Route::put('carros/{id?}', ['as' => 'update', 'uses' => 'ApiController@update']);
    Route::delete('carros/{id}', ['as' => 'delete', 'uses' => 'ApiController@destroy']);
});
