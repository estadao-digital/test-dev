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

Route::get('/', function () {
    return view('welcome');
});


/*
|
|--------------------------------------------------------------------------
| CARRO
|--------------------------------------------------------------------------
|
*/

    Route::get('/pagina-inicial', 'Car\CarController@home')->name('car.home');
    Route::get('/carros', 'Car\CarController@index')->name('car.index');
    Route::post('/carros', 'Car\CarController@store')->name('car.store');
    Route::get('/carros/{id}', 'Car\CarController@show')->name('car.show');
    Route::put('/carros/{id}', 'Car\CarController@update')->name('car.update');
    Route::delete('/carros/{id}', 'Car\CarController@destroy')->name('car.destroy');


/*
|
|--------------------------------------------------------------------------
| MARCA
|--------------------------------------------------------------------------
|
*/

    Route::get('/marcas', 'Brand\BrandController@index')->name('brand.index');
