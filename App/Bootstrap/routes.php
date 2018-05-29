<?php
/**
 * File routes.php
 *
 * PHP version 5.6
 *
 * @category Bootstrap
 * @package  FastApi
 * @author   mmfjunior1@gmail.com <mmfjunior1@gmail.com>
 * @license  mmfjunior1@gmail.com Proprietary
 * @link     
 */
require '../vendor/autoload.php';

use FastApi\Routing\Routing;

Routing::add('/', 'BaseController@index', array('method' => 'GET',));
