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

Route::get('/carros',    'CarroController@listarCarros'); // retorna todos os carros cadastrados
Route::post('/carros',   'CarroController@registrarCarro'); // cadastra um novo carro
Route::get('/carros/{id}',    'CarroController@obterCarro'); // retorna um carro pelo ID especificado
Route::put('/carros/{id}', 'CarroController@atualizarCarro'); // atualiza os dados de um carro pelo ID
Route::delete('/carros/{id}', 'CarroController@deletarCarro'); // deleta um carro pelo ID

