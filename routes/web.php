<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Operações de CRUD para o Objeto Carro
|
*/

Route::get('/', 'CarController@getCars');

Route::get('/carros', 'CarController@getCars')->name('index');

Route::post('/carros', 'CarController@storeCar')->name('store');

Route::get('/carros/{id}', 'CarController@getCar')->name('find');

Route::put('/carros/{id}', 'CarController@updateCar')->name('update');

Route::delete('/carros/{id}', 'CarController@deleteCar')->name('delete');

