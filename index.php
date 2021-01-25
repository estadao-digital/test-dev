<?php

require_once 'app/servicos/operacoesBanco.php';

include_once 'Request.php';
include_once 'Router.php';
include_once 'home.php';
$router = new Router(new Request);

$router->get('/', function() {
    global $page;

    return $page;
});

$router->get('/carros', function($request) {
    $carros = pegaTabela('carros');

    return json_encode($carros);
});

$router->post('/carros', function($request) {
    $carro = $request->getBody();
    criaTupla('carros', $carro);
    return "CRIADO";
});

$router->post('/edita_carros', function($request) {
    $carro = $request->getBody();
    editaTupla('carros', $carro);
    return "EDITADO";
});

$router->post('/deleta_carros', function($request) {
    $carro = $request->getBody();
    deletaTupla('carros', $carro['id']);
    return "DELETADO";
});

$router->get('/marcas', function($request) {
    $marcas = pegaTabela('marcas');

    return json_encode($marcas);
});
