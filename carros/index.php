<?php
// CORS
if(isset($_SERVER["HTTP_ORIGIN"]))
{
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
}
else
{
    header("Access-Control-Allow-Origin: *");
}

header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 600"); // cache configurado para 10 minutos

if($_SERVER["REQUEST_METHOD"] == "OPTIONS")
{
    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))
        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT");

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}


//Autoload
$loader = require 'vendor/autoload.php';

//Instanciando objeto
$app = new \Slim\Slim(array(
    'templates.path' => 'templates'
));

//Listagem de todos os Carros
$app->get('/', function() use ($app){
	(new \controllers\Carro($app))->listCar();
});

//Listagem de todas as Marcas
$app->get('/marcas/', function() use ($app){
	(new \controllers\Carro($app))->listBrands();
});

//Obtenção de Carro
$app->get('/:id', function($id) use ($app){
	(new \controllers\Carro($app))->getCar($id);
});

//Criação de novo Carro
$app->post('/', function() use ($app){
	(new \controllers\Carro($app))->newCar();
});

//Edição de Carro
$app->put('/:id', function($id) use ($app){
	(new \controllers\Carro($app))->editCar($id);
});

//Remoção de Carro
$app->delete('/:id', function($id) use ($app){
	(new \controllers\Carro($app))->delCar($id);
});

//Execução
$app->run();