<?php
/**
 * Api V1 Routes
 */
use \App\Services\JWTSimple;

$router->group(['prefix' => 'api/v1'], function () use ($router) {
    /**
     * authenticated routes 'middleware' => 'auth'
     */
    $router->group([], function () use ($router) {
        $router->get('car', ['as' => 'car-all', 'uses' => 'CarController@index']);
        $router->get('car/{id}', ['as' => 'car-find', 'uses' => 'CarController@show']);
        $router->post('car/create', ['as' => 'car-create', 'uses' => 'CarController@store']);
        $router->put('car/{id}', ['as' => 'car-edit', 'uses' => 'CarController@edit']);
        $router->patch('car/{id}', ['as' => 'car-edit', 'uses' => 'CarController@edit']);
        $router->delete('car/{id}/', ['as' => 'car-remove', 'uses' => 'CarController@destroy']);
    });

    /**
     * Returns token
     */
    $router->get('token', function (JWTSimple $jwt) {
        $token = $jwt->encode();
        return response()->json(['token' => $token]);
    });

});
