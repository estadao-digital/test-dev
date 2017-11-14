<?php

use Psr7Middlewares\Middleware\TrailingSlash;

/**
 * Middleware Tratamento da / do Request 
 * true - Adiciona a / no final da URL
 * false - Remove a / no final da URL
 */
$app->add(new TrailingSlash(false));

/**
 * Middleware to access control origin
 */
$headers = function ($request, $response, $next) {
	$response = $next($request, $response);

	return $response->withHeader('Access-Control-Allow-Origin', '*')
			->withHeader('Access-Control-Allow-Credentials', 'true')
			->withHeader('Access-Control-Allow-Headers', 'X-Requested-With, Access-Control-Allow-Origin, Origin, Content-Type, Accept, Authorization, X-Token')
			->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS');
};

$app->add($headers);

