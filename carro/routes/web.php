<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('carros', 'CarroCrudController');


// Route::delete('carros/{id}', 'CarroCrudController@destroy')->name('carros.destroy');
// Route::put('carros/{id}', 'CarroCrudController@update')->name('carros.update');
// Route::get('carros/{id}', 'CarroCrudController@edit')->name('carros.edit');
// Route::get('carros/create', 'CarroCrudController@create')->name('carros.create');
// Route::get('carros/{id}', 'CarroCrudController@show')->name('carros.show');
// Route::get('carros', 'CarroCrudController@index')->name('carros.index');
// Route::post('carros', 'CarroCrudController@store')->name('carros.store');