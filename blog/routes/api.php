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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

$params = [
    'as' => 'api::',
    'version' => 'v1',
    'domain' => env('dev.laravel'), // Notice we use the domain WITHOUT port number
    'namespace' => 'App\\Http\\Controllers',
];

Route::group(array('prefix' => 'v1', 'middleware' => []), function () {
    // Custom route added to standard Resource
    Route::get('example/foo', 'ExampleController@foo');
    // Standard Resource route
//    Route::resource('example', 'ExampleController');

});




//Route::group(['prefix' => 'v1'], function() {
//    Route::get('example/foo', 'ExampleController@foo');
//
//});

//Route::group(['prefix' => 'v1'], function() {
//    Route::get('example/foo', 'ExampleController@foo');
//
//});