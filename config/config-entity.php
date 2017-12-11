<?php
/**
 * Created by PhpStorm.
 * Agency: OnFour
 * Developer: Gerlisson Paulino
 * Email: gerlisson.paulino@gmail.com
 * Date: 24/05/2017
 */

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Registry\Registry;

setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
date_default_timezone_set('America/Sao_Paulo');

/* ** DEFINE DIRETÓRIO ** */
define('DS', DIRECTORY_SEPARATOR);
define('DIR_SITE', dirname(__DIR__) . DS);
define('DIR_DATAPROXIES', DIR_SITE . 'data/Proxies' . DS);

@require_once("local.php");

define('URL_MAIN', $config['url']);

$paths = array(
    'module/Vehicle/src/Entity'
);
$isDevMode = false;

$dbParams = array(
    'driver' => 'pdo_mysql',
    'user' => $config['datebase']['username'],
    'password' => $config['datebase']['password'],
    'dbname' => $config['datebase']['dbname'],
    'charset' => 'utf8',
    'driverOptions' => array(
        1002 => 'SET NAMES utf8'
    )
);
$doctrineConfig = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode);
//$doctrineConfig->setAutoGenerateProxyClasses(true);
$doctrineConfig->addFilter("ProductAvailableFilter", "ProductAvailableFilter");
//$doctrineConfig->setSQLLogger(new \Doctrine\DBAL\Logging\EchoSQLLogger());
$doctrineConfig->setProxyDir(DIR_DATAPROXIES);
$entityManager = EntityManager::create($dbParams, $doctrineConfig);

registry::register('entityManager', function () use ($dbParams, $doctrineConfig) {
    return EntityManager::create($dbParams, $doctrineConfig);
});