<?php

use Illuminate\Http\Request;

//use Illuminate\Routing\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
  //  return $request->user();
//});


Route::namespace('API')->group(function(){
    Route::get('/crud', 'CrudController@index')->name('api.crud');
    Route::get('/crud/{id}', 'CrudController@show')->name('api.show');
    Route::post('/crud', 'CrudController@store')->name('api.store');
    Route::put('/crud/{id}', 'CrudController@update')->name('api.update');
    Route::delete('/crud/{id}', 'CrudController@delete')->name('api.delete');
});