<?php

use App\Carro;
use App\Marca;


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/api', ['middleware' => 'cors',function () {
    return "Api version 1.0";
}]);

// /marcas - [GET] retornar todas os marcas cadastradas.
$router->get('/marcas', ['middleware' => 'cors',function() {
    return Marca::all();
}]);

// /carros - [GET] retornar todos os carros cadastrados.
$router->get('/carros', ['middleware' => 'cors',function() {
    return Carro::all();
}]);

// /carros - [POST] cadastrar um novo carro.
$router->post('/carros', ['middleware' => 'cors',function(Illuminate\Http\Request $request) {
    return Carro::create($request);
}]);

// /carros/{id}[GET] retornar o carro com ID especificado.
$router->get('/carros/{id}', ['middleware' => 'cors',function($id) {
    return Carro::find($id);
}]);

// /carros/{id}[PUT] atualizar os dados do carro com ID especificado.
$router->put('/carros/{id}', ['middleware' => 'cors',function(Illuminate\Http\Request $request, $id) {
    return Carro::update($request, $id);
}]);

// /carros/{id}[DELETE] apagar o carro com ID especificado.
$router->delete('/carros/{id}', ['middleware' => 'cors',function($id) {
    return Carro::delete($id);
}]);