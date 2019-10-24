<?php

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

require_once "vendor/autoload.php";

$isDevMode = true;
$config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/src/Entities"), $isDevMode);

$conn = array(
    'dbname'    => 'estadao',
    'user'      => 'estadao',
    'password'  => 'secret',
    'host'      => 'localhost',
    'driver'    => 'pdo_mysql'
);

$entityManeger = EntityManager::create($conn, $config);