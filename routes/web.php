<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Operações de CRUD para o Objeto Carroro
|
*/

Route::get('/', 'CarroController@getCarros');

Route::get('/carros', 'CarroController@getCarros')->name('index');

Route::post('/carros', 'CarroController@storeCarro')->name('store');

Route::get('/carros/{id}', 'CarroController@getCarro')->name('find');

Route::put('/carros/{id}', 'CarroController@updateCarro')->name('update');

Route::delete('/carros/{id}', 'CarroController@deleteCarro')->name('delete');

Route::get('/modelos/{idMarca}', 'ModeloController@getModelos');
