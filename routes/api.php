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
Route::get('/carros','CarrosController@index')->name('lista_carros');
Route::post('/carros','CarrosController@cadastrarVeiculo')->name('cadastra_carro');
Route::get('/carros/{id}','CarrosController@buscarVeiculo')->name('buscar_carro');
Route::put('/carros/{id}','CarrosController@atualizarVeiculo')->name('atualiza_carro');
Route::delete('/carros/{id}','CarrosController@deletarVeiculo')->name('remove_carro');
