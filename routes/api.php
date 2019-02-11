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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * Quando utilizado o metodo resource automaticamente são criados as rotas
 * /carros [GET]
 * /carros [POST]
 * /carros/{id}[GET]
 * /carros/{id}[PUT]
 * /carros/{id}[DELETE]
 *
 * desde que os metodos dentro do controller fiquem com o nome (index,store,show,update,delete) respectivamente
 *
 */
Route::resource('carros', 'CarrosController');
Route::resource('marcas', 'MarcasController');