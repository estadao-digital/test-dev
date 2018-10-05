<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

require './vendor/autoload.php';

use Model\CarroModel;
use Model\CarroDAO;

$app = new \Slim\App;

$app->add(function ($request, $response, $next) {
	$response = $next($request, $response);
	$response = $response
                  ->withHeader('Access-Control-Allow-Origin', '*')
                  ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization, X-Http-Method-Override')
                  ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
	return $response;
});

$app->get('/carros', function (Request $request, Response $response, array $args) {
  $dao = new CarroDAO();
  $carros = $dao->read();

  $response->getBody()->write(json_encode($carros));
  return $response;
});

$app->get('/carros/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];
  $dao = new CarroDAO();
  $carros = $dao->get($id);

  $response->getBody()->write(json_encode($carros));
  return $response;
});

$app->post('/carros', function (Request $request, Response $response, array $args) {
  $novoCarro = $request->getParsedBody();

  $carro = new CarroModel();
  $carro->marca = $novoCarro['marca'];
  $carro->modelo = $novoCarro['modelo'];
  $carro->ano = $novoCarro['ano'];
  
  $dao = new CarroDAO();
  $carroCadastrado = $dao->create($carro);

  $response->getBody()->write(json_encode($carroCadastrado));
  return $response();
});

$app->put('/carros', function (Request $request, Response $response, array $args) {
  $carro = $request->getParsedBody();
  $carroEditar = new CarroModel();
  $carroEditar->id = $carro['id'];
  $carroEditar->marca = $carro['marca'];
  $carroEditar->modelo = $carro['modelo'];
  $carroEditar->ano = $carro['ano'];

  $dao = new CarroDAO;
  $dao->update($carroEditar);

  $msg = ['success' => true];
  $response->getBody()->write(json_encode($msg));
  return $response;

});

$app->delete('/carros/{id}', function (Request $request, Response $response, array $args) {
  $id = $args['id'];
  $dao = new CarroDAO();
  $dao->delete($id);

  $msg = ['success' => true];
  $response->getBody()->write(json_encode($msg));
  return $response;
});

$app->run();
