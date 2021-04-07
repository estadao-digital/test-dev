<?php

// Cars
$route->get('/carros', 'CarsController@index');
$route->get('/carros/{id}', 'CarsController@view');
$route->post('/carros', 'CarsController@create');
$route->put('/carros/{id}', 'CarsController@update');
$route->delete('/carros/{id}', 'CarsController@delete');