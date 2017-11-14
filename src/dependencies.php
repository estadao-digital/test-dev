<?php
// DIC configuration

$container = $app->getContainer();

// Configure eloquent
$container['db'] = function ($c) {
    $settings = $c->get('settings')['db'];
    $capsule = new \Illuminate\Database\Capsule\Manager;
    $capsule->addConnection($settings);

    $capsule->setAsGlobal();
    $capsule->bootEloquent();

    return $capsule;
};

// Initialize eloquent
$container->get("db");

// Register component on container
$container['view'] = function ($container) {
    return new \Slim\Views\PhpRenderer('../templates/');
};