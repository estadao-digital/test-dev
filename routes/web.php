<?php

Route::group(['middleware' => 'auth'], function ($router) {
    Route::get('', 'CarController@index')->name('carros');
    Route::post('carros', 'CarController@store');
    Route::post('carros/{id}', 'CarController@update');
    Route::delete('carros/{id}', 'CarController@destroy');
});

Route::get('/login', 'AuthController@index')->name('login');
Route::post('/login', 'AuthController@login');
Route::get('/logout', 'AuthController@logout');
Route::get('/registrar', 'RegisterController@create');
Route::post('/registrar', 'RegisterController@store');
