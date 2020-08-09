<?php
/**
 * Home route
 */
$router->get('/', ['as' => 'home', 'uses' => 'HomeController@index']);
