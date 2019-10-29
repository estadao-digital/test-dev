<?php
// Require composer autoloader
require_once('Controller/CarroController.php');
use Controller\CarroController;
require __DIR__ . '\vendor\autoload.php';

$controller = new CarroController();
// Create Router instance
$router = new \Bramus\Router\Router();

// Define routes
// ...
$router->get('/', function() {
    readfile('index.html');
});

$router->delete('/carros/{id}', function($id) {
    $controller = new CarroController();
    $controller->destroy($id);
});
$router->put('/carros/{id}', function($id) {
    $controller = new CarroController();
    $controller->update($id);
});

$router->get('/carros/{id}', function($id) {
    $controller = new CarroController();
    $controller->show($id);
});

$router->post('/carros', function() {

    $controller = new CarroController();
    $controller->create();
});

$router->get('/carros', function() {
    $controller = new CarroController();
    $controller->index();
});


// Run it!
$router->run();
?>