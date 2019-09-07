<?php

Route::group(['prefix' => 'carros'], function() {
    Route::get('/', 'CarroController@index')->name('carros/index');
    Route::get('/create', 'CarroController@create')->name('carros/create');
    Route::post('/', 'CarroController@store')->name('carros/store');
    Route::get('/{id}/edit', 'CarroController@edit')->name('carros/edit');
    Route::get('/{id}', 'CarroController@show')->name('carros/show');
    Route::put('{id}', 'CarroController@update')->name('carros/update');
    Route::delete('{id}', 'CarroController@destroy')->name('carros/destroy');
});

Route::get('/', 'CarroController@index');