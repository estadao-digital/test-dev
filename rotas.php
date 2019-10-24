<?php
// Require composer autoloader
require __DIR__ . '/vendor/autoload.php';
require 'Controller/Carros.php';

// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
// ...
$router->get('/', function() {
    readfile('index.html');
});

$router->delete('/carros/{id}', function($id) {
    echo 'hello word';
});
$router->put('/carros/{id}', function($id) {
    echo 'hello word';
});
$router->get('/carros/{id}', function($id) {
    echo $id;
});
$router->get('/carros', function() {
    echo 'wwww';
});


// Run it!
$router->run();;
?>