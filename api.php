<?php

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: *');
header('Access-Control-Allow-Headers: *');

$loader = require __DIR__ . '/vendor/autoload.php';

$app = new \Slim\Slim();

$app->get('(/)', function () {
    $cars =  new Models\Cars();
    echo json_encode($cars->findAll());
});

$app->get('/cars(/(:id))', function ($id = null) {
    $cars =  new Models\Cars();
    if (!$id) {
        echo json_encode($cars->findAll());
    } else {
        echo json_encode($cars->find($id));
    }
});

$app->post('/cars(/)', function () {
    $car = new Models\Cars();

    $json = [
        'brand' => $_POST['brand'],
        'model' => $_POST['model'],
        'year' => $_POST['year'],
    ];

    $car->insert($json);
});

$app->post('/cars(/(:id))', function ($id = null) {
    $car = new Models\Cars();

    if (isset($_POST['id'])) {
        $json = [
            'id' => $_POST['id'],
            'brand' => $_POST['brand'],
            'model' => $_POST['model'],
            'year' => $_POST['year'],
        ];

        $car->update($json, $id);

    } else {
        $car->delete($id);

    }
});

$app->put('/cars(/(:id))', function ($id = null) {
    $app = \Slim\Slim::getInstance();
    $json = json_decode($app->request()->getBody());

    $car = new Models\Cars();
    $car->update($json, $id);
});

$app->delete('/cars(/(:id))', function ($id = null) {
    $app = \Slim\Slim::getInstance();
    $json = json_decode($app->request()->getBody());

    $car = new Models\Cars();
    $car->delete($json);
});

$app->run();
