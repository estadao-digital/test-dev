<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


$router->group(['prefix' => 'carros'], function () use($router) {
    $router->get('/', 'CarrosController@all');
    $router->get('/{id}', 'CarrosController@find');
    $router->post('/', 'CarrosController@store');
    $router->put('/{id}', 'CarrosController@update');
    $router->delete('/{id}', 'CarrosController@delete');
});
