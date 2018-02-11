<?php
require 'vendor/autoload.php';
/*$controllers = glob('controllers/*.php');
foreach ($controllers as $file) {
    require($file);   
}
$models = glob('models/*.php');
foreach ($models as $file) {
    require($file);   
}*/


require 'controllers/AppController.php';
require 'models/AppModel.php';

require 'controllers/CarsController.php';
require 'models/Car.php';
$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];
$c = new \Slim\Container($configuration);
$app = new \Slim\App($c);

//get all cars
$app->get('/carros[/]', function($request, $response){
	$return = (new controllers\CarsController())->getCars();
	return $response->withJson($return);
});

//get single car
$app->get('/carros/{id}', function($request, $response, $args){
	$return = (new \controllers\CarsController())->getCar($args['id']);
	return $response->withJson($return);
});

//new car
$app->post('/carros[/]', function($request, $response){
	//get json from request
	$json = $request->getBody();
	$data = json_decode($json, true);

	$return = (new \controllers\CarsController())->addCar($data);
	return $response->withJson($return);
});
 
//update car
$app->put('/carros/{id}', function($request, $response, $args){
	//get json from request
	$json = $request->getBody();
	$data = json_decode($json, true);

	$return = (new \controllers\CarsController())->updateCar($args['id'], $data);
	return $response->withJson($return);
});
 
//apaga Carro
$app->delete('/carros/{id}', function($request, $response, $args){
	$return = (new \controllers\CarsController())->deleteCar($args['id']);
	return $response->withJson($return);
});

//Run application
$app->run();

