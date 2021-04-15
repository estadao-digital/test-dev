<?php

Route::get('/', function () {
    return view('index');
});

Route::get('/carros', 'CarroController@indexView');
Route::get('/marcas', 'MarcaController@list')->name('marcas');