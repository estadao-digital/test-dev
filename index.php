<?php

require 'startup.php';

require 'autoload.php';

$route = new App\Router();

$route->setNamespace('App')
->get('/', 'Cars@index')
->group('/carros', function() use ($route) {
    $route->get('/', 'Cars@all')
    ->post('/', 'Cars@add')
    ->get('/(\d+)', 'Cars@get')
    ->put('/(\d+)', 'Cars@update')
    ->delete('/(\d+)', 'Cars@delete');
})
->setNotFound(function() {
    include DIR_ROOT . 'View/not_found.html';
})
->dispatch();