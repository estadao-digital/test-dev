<?php
//Confgurando as rotas
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();

//$router->controller('/cdc', 'Controller\\CronogramaDC');

$router->get(['/carro/{name}', 'username'], function($name){
    return 'Hello ' . $name;
});

$router->get('/test-dev/example', function(){
    echo 'This route responds to requests with the GET method at the path /example';
});

return $router->getData();