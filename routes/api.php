<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
/carros - [GET] deve retornar todos os carros cadastrados.
/carros - [POST] deve cadastrar um novo carro.
/carros/{id}[GET] deve retornar o carro com ID especificado.
/carros/{id}[PUT] deve atualizar os dados do carro com ID especificado.
/carros/{id}[DELETE] deve apagar o carro com ID especificado.
|
*/

Route::apiResource('carros', 'CarroController');
Route::apiResource('marcas', 'MarcaController');


