<?php

$route->get('/carros', 'CarrosController@index');

$route->get('/carros/{id}', 'CarrosController@view');

$route->post('/carros', 'CarrosController@create');

$route->post('/carros/{id}', function ($request) {
    return json_encode($request->getBody());
});