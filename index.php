<?php

$loader = require __DIR__ . '/vendor/autoload.php';

$app = new \Slim\Slim();

$app->get('(/)', function () {
    echo json_encode(null);
});

$app->get('/cars(/(:id))', function ($id = null) 
{
    $cars =  new Models\Cars();
    
    if (!$id) {
        echo json_encode($cars->findAll());
    } else {
        echo json_encode($cars->find($id));
    }
    
});

$app->post('/cars(/)', function() {
    $app = \Slim\Slim::getInstance();
    $json = json_decode($app->request()->getBody());
    
    $car = new Models\Cars();
    echo json_encode($car->insert($json));
});

$app->put('/cars(/(:id))', function($id = null) {
    $app = \Slim\Slim::getInstance();
    $json = json_decode($app->request()->getBody());
    
    $car = new Models\Cars();
    echo json_encode($car->update($json, $id));
});

$app->delete('/cars(/(:id))', function($id = null) {    
    $car = new Models\Cars();
    echo json_encode($car->delete($id));
});

$app->run();
