<?php

Route::get('/veiculo', 'api\VeiculosController@index');
Route::post('/veiculo', 'api\VeiculosController@store');
Route::put('/veiculo/{id}', 'api\VeiculosController@update');
Route::get('/veiculo/{id}', 'api\VeiculosController@show');
Route::delete('/veiculo/{id}', 'api\VeiculosController@destroy');


