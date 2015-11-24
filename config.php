<?php

define('APP_DIR', __DIR__ );
define('BASE_URL', '/estadao' );
define('DS', DIRECTORY_SEPARATOR );

$config_database = [
    'host'=>'127.0.0.1',
    'driver'=>'mysql',
    'user' => 'estadao',
    'password'=>'123456',
    'default_database'=>'carros',
];
ActiveRecord\Config::initialize(function($cfg) use ($config_database)
{
    $cfg->set_model_directory('.');
    $cfg->set_connections(array('development' => "{$config_database['driver']}://{$config_database['user']}:{$config_database['password']}@{$config_database['host']}/{$config_database['default_database']}"));    
});


