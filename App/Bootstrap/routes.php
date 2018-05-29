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
Routing::add('/carros', 'CarrosController@listaCarros', array('method' => 'GET',));
Routing::add('/carros/lista/filtrar', 'CarrosController@listaCarros', array('method' => 'POST',));
Routing::add('/carros', 'CarrosController@salvarCarro', array('method' => 'POST',));
Routing::add('/carros/{id}', 'CarrosController@salvarCarro', array('method' => 'PUT',));
Routing::add('/carros/{id}', 'CarrosController@verCarro', array('method' => 'GET',));
Routing::add('/carros/{id}', 'CarrosController@excluirCarro', array('method' => 'DELETE',));
Routing::add('/carros/marcas/listar', 'CarrosController@marcasCarro', array('method' => 'GET',));
