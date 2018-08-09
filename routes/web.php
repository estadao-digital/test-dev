<?php

Route::get('/', function () {  return view('welcome');
});
/*******************************************/
Route::get('/api/carros','carros@lista');
Route::post('/api/carros','carros@cadastra');
Route::get('/api/carros/{id}','carros@detalhe');
Route::put('/api/carros/{id}','carros@update');
Route::delete('/api/carros/{id}','carros@deleta');
Route::get('/carros','carros@Home');

