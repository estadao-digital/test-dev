<?php

use Illuminate\Http\Request;

//User Routes
Route::group(['prefix' => 'auth', 'namespace' => 'Api'], function ($router) {
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::get('me', 'AuthController@me');
});

//Car Process With User Authentication
//Route::group(['middleware' => 'apiJwt', 'namespace' => 'Api'], function ($router) {
Route::group(['namespace' => 'Api'], function ($router) {
    Route::get('carros', 'CarController@index');
    Route::post('carros', 'CarController@store');
    Route::get('carros/{id}', 'CarController@show');
    Route::put('carros/{id}', 'CarController@update');
    Route::delete('carros/{id}', 'CarController@destroy');
});

//Get All Users
Route::get('users', 'Api\UserController@index');
