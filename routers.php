<?php
global $routes;
$routes = array();

$routes['/'] = '/home/index';

$routes['/carros'] = '/api/index';
$routes['/carros/{id}'] = '/api/view/:id';