<?php

use Pecee\SimpleRouter\SimpleRouter;
use App\Controllers\CarsController;

SimpleRouter::get('/', function() {
    return header('Location: http://localhost:8080/index.html');
});
SimpleRouter::get('/carros', [CarsController::class, 'read']);
SimpleRouter::post('/carros', [CarsController::class, 'create']);
SimpleRouter::get('/carros/{id}', [CarsController::class, 'readOne']);
SimpleRouter::put('/carros/{id}', [CarsController::class, 'update']);
SimpleRouter::delete('/carros/{id}', [CarsController::class, 'delete']);
