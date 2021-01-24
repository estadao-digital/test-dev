<?php

require_once 'app/servicos/operacoesBanco.php';

include_once 'Request.php';
include_once 'Router.php';
$router = new Router(new Request);

$router->get('/', function() {
return <<<HTML
<h1>Hello world</h1>
HTML;
});


$router->get('/carros', function($request) {
    $carros = pegaTabela('carros');

    return json_encode($carros);
});

$router->post('/carros', function($request) {
    $carro = $request->getBody();
    criaTupla('carros', $carro);
    return "OK";
});

$router->post('/edita_carros', function($request) {
    $carro = $request->getBody();
    editaTupla('carros', $carro);
    return "OK";
});

$router->post('/deleta_carros', function($request) {
    $carro = $request->getBody();
    deletaTupla('carros', $carro['id']);
    return "OK";
});
