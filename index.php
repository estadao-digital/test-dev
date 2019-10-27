<?php

$loader = require __DIR__ . '/vendor/autoload.php';

use Entities\Cars;
use Models\CarsDAO;

$app = new \Slim\Slim();

$cars =  new Cars();
$carsDAO = new CarsDAO();

$app->get('(/)', function () use ($carsDAO) {
    echo json_encode($carsDAO->findAll()->toArray());
});

$app->get('/cars(/(:id))', function ($id = null) use ($carsDAO) {
    echo json_encode($carsDAO->find($id));
});

$app->run();
