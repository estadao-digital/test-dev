<?php
// Require composer autoloader
require_once 'Controller/Carros.php';
require __DIR__ . '/vendor/autoload.php';

$controller = new CarroController();
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
    echo $controller->index();
});


// Run it!
$router->run();;
?>