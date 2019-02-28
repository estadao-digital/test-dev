<?php

header('Content-Type: application/json');

use Api\Routes;
use Api\Provider;

$container = [];

$repositoryProvider = new Provider\RepositoryProvider();
$serviceProvider = new Provider\ServiceProvider();

$container = $repositoryProvider->register($container); 
$container = $serviceProvider->register($container);

new Routes\CarRoutes('/carros', $container);
new Routes\CarRoutes('/tests', $container);
