<?php

$url_router = isset($_GET['_url']) ? $_GET['_url'] : '';
$url_router = !empty($url_router) ? trim($url_router, '/') : '';
$route_array = explode('/', $url_router);

$controller = $route_array[0] ? $route_array[0] : '';
$params = count($route_array) > 1 ? array_slice($route_array, 1) : [];

if (class_exists(ucfirst($controller))) {
    $controller = new $controller();
    $result = call_user_func_array([$controller, 'index'], $params);
    echo $result;
    exit;
}
