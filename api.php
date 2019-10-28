<?php

session_start();

header('Access-Control-Request-Methods: *');
header('Access-Control-Request-Headers: *');

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

$loader = require __DIR__ . '/vendor/autoload.php';

$app = new \Slim\Slim();

/**
 * SELECT METHODS
 */

$app->get('/cars(/)', function () {
    $cars =  new Models\Cars();
    echo json_encode($cars->findAll());
});

$app->get('/cars(/(:id))', function ($id = null) {
    $cars =  new Models\Cars();
    echo json_encode($cars->find($id));
});

/**
 * INSERT METHOD
 */

$app->post('/cars(/)', function () {
    $car = new Models\Cars();

    $app = \Slim\Slim::getInstance();
    $json = json_decode($app->request()->getBody());

    echo json_encode($car->insert($json));
});

$app->post('/cars(/(:id))', function ($id = null) {
    $car = new Models\Cars();

    $app = \Slim\Slim::getInstance();
    $json = json_decode($app->request()->getBody());

    if (!$json) {
        echo json_encode($car->delete($id));
    } else {
        echo json_encode($car->update($json, $id));
    }

});

/**
 * UPDATE METHOD
 */

$app->put('/cars(/(:id))', function ($id = null) {
    $car = new Models\Cars();

    $app = \Slim\Slim::getInstance();
    $json = json_decode($app->request()->getBody());

    echo json_encode($car->update($json, $id));
});

/**
 * DELETE METHOD
 */

$app->delete('/cars(/(:id))', function ($id = null) {
    $car = new Models\Cars();
    echo json_encode($car->delete($id));
});

/**
 * RUN API
 */

$app->run();
