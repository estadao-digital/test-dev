<?php
/**
 * File index.php
 *
 * PHP version 5.6
 *
 * @category Public
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
require '../vendor/autoload.php';

$app = new App\Bootstrap\Init();
$app->run();
