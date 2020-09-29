<?php

use DI\Container;
use DI\Bridge\Slim\Bridge as SlimAppFactory;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$settings = require __DIR__ . '/../config/settings.php';
$settings($container);

$app = SlimAppFactory::create($container);

$database = require __DIR__ . '/../config/database.php';
$database($app);

$middleware = require __DIR__ . '/../config/middleware.php';
$middleware($app);

$routes = require __DIR__ . '/../config/routes.php';
$routes($app);
