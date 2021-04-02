<?php

$route->get('/carros', 'CarrosController@index');

$route->post('/carros/{id}', function ($request) {
    return json_encode($request->getBody());
});