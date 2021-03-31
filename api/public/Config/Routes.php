<?php

$route->get('/carros', function ($request) {
    return 'Carros';
});

$route->post('/carros/{id}', function ($request) {
    return json_encode($request->getBody());
});