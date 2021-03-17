<?php

use Core\Routing\Router;

if ( $_SERVER['REQUEST_METHOD'] == "OPTIONS" ) {
    header('Access-Control-Allow-Origin: *');
    header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Access-Control-Request-Headers, Authorization");
    die;
}

Router::add('/marcas', function() {
    return 'MarcaController@index';
});

Router::add('/carros', function() {
    return 'CarroController@index';
});

Router::add('/carros/([0-9]*)', function() {
    return 'CarroController@index';
});

Router::add('/carros', function() {
    return 'CarroController@store';
}, 'post');

Router::add('/carros/([0-9]*)', function() {
    return 'CarroController@update';
}, 'put');

Router::add('/carros/([0-9]*)', function() {
    return 'CarroController@destroy';
}, 'delete');

// Add a 404 not found route
Router::pathNotFound( function($path) {
    http_response_code(404);
    echo 'The requested path "'.$path.'" was not found!';
});
  
// Add a 405 method not allowed route
Router::methodNotAllowed( function($path, $method) {
    http_response_code(405);
    echo 'The requested path "'.$path.'" exists. But the request method "'.$method.'" is not allowed on this path!';
});

Router::run('/');