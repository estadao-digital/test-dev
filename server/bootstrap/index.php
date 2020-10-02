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

$app->options('/{routes:.+}', function ($request, $response, $args) {
	return $response;
});

$app->add(function ($request, $handler) {
	$response = $handler->handle($request);
	return $response
		  ->withHeader('Access-Control-Allow-Origin', 'http://localhost:3000')
		  ->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Content-Type, Accept, Origin, Authorization')
		  ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, PATCH, OPTIONS');
});

$routes = require __DIR__ . '/../config/routes.php';
$routes($app);

$app->map(['GET', 'POST', 'PUT', 'DELETE', 'PATCH'], '/{routes:.+}', function ($request, $response) {
	throw new HttpNotFoundException($request);
});
