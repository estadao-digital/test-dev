<?php

use app\lib\Router;

include_once './vendor/autoload.php';


$route = [
    'method' => strtolower($_SERVER['REQUEST_METHOD']),
    'url' => strtolower($_SERVER['REQUEST_URI']),
];
$router = new Router($route);
