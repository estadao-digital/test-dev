<?php
require_once __DIR__ . '/src/includes/autoload.php';

use lib\Request;
use lib\Response;
use lib\Router;

use api\Cars;
use api\Makers;

Cars::load();
Makers::load();

Router::get('/cars', function (Request $req, Response $res) {
  $res->toJSON(Cars::takeAll());
});

Router::post('/cars', function (Request $req, Response $res) {
  $car = Cars::add($req->getJSON());
  $res->status(201)->toJSON($car);
});

Router::get('/cars/([0-9]*)', function (Request $req, Response $res) {
  $car = Cars::takeById($req->params[0]);

  if ($car) {
    $res->toJSON($car);
  } else {
    $res->status(404)->toJSON(['error' => 'Not Found']);
  }
});

Router::put('/cars/([0-9]*)', function (Request $req, Response $res) {
  $car = Cars::takeById($req->params[0]);

  if ($car) {
    $updated = Cars::edit($car->id, $req->getJSON());
    $res->status(200)->toJSON($updated);
  } else {
    $res->status(404)->toJSON(['error' => 'Not Found']);
  }
});

Router::delete('/cars/([0-9]*)', function (Request $req, Response $res) {
  $car = Cars::takeById($req->params[0]);

  if ($car) {
    Cars::remove($car->id);
    $res->status(204);
  } else {
    $res->status(404)->toJSON(['error' => 'Not Found']);
  }
});

Router::get('/makers', function (Request $req, Response $res) {
  $res->toJSON(Makers::takeAll());
});
