<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/carros','CarrosController@index');
Route::post('/carros','CarrosController@cadastrarVeiculo');
Route::get('/carros/{id}','CarrosController@buscarVeiculo');
Route::put('/carros/{id}','CarrosController@atualizarVeiculo');
Route::delete('/carros/{id}','CarrosController@deletarVeiculo');
