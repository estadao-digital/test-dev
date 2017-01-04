<?php
//Confgurando as rotas
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

$router->controller('/carros', 'Teste\\Controller\\Carros');

$router->get('/test-dev/', function(){
    return 'Hello dear' ;
});

$router->get('/example', function(){
    return 'This route responds to requests with the GET method at the path /example';
});

return $router->getData();