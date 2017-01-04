<?php
//Confgurando as rotas
use Phroute\Phroute\RouteCollector;

$router = new RouteCollector();
$carroModel = new Teste\CarroModel(new \Teste\ControleBanco());

$router->get('/home', function(){
    //echo __BASE__.'public/index.html';
    include __BASE__.'public/home.php';
    return '';
    //return file_get_contents(__BASE__.'public/home.php');
});

// `/marcas` - [GET] deve retornar todos os carros cadastrados.
$router->get('/marcas', function() {
    return json_encode(Funcoes::listaMarcas());
});

// `/carros` - [GET] deve retornar todos os carros cadastrados.
$router->get('/carros', function() use($carroModel){
    return $carroModel->buscaCarros();
});

// /carros/{id}`[GET] deve retornar o carro com ID especificado.
$router->get('/carros/{id:i}', function($id) use($carroModel){
    return $carroModel->buscaCarros($id);
});

// `/carros` - [POST] deve cadastrar um novo carro.
$router->post('/carros', function() use($carroModel, $request){
    return $carroModel->insereCarro($request);
});

// `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
$router->put('/carros/{id:i}', function($id) use($carroModel, $request){
    return $carroModel->atualizaCarro($id, $request);
});

// `/carros/{id}`[PUT] deve atualizar os dados do carro com ID especificado.
$router->delete('/carros/{id:i}', function($id) use($carroModel){
    return $carroModel->deletaCarro($id);
});

return $router->getData();