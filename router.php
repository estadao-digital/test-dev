<?php


    use CoffeeCode\Router\Router;


    $router = new Router('http://localhost:8080');

    $router->namespace('Src\Controllers');

    $router->group(null);

    $router->get('/', 'CarrosController:home');

    $router->get('/Carros', 'CarrosController:index');

    $router->get('/Carros/{id}', 'CarrosController:show');

    $router->delete('/Carros/{id}', 'CarrosController:destroy');

    $router->put('/Carros/{id}', 'CarrosController:edit');

    $router->post('/Carros', 'CarrosController:store');


    $router->get('/Marcas', 'MarcasController:index');

    $router->get('/Modelos', 'ModelosController:index');

    $router->get('/Modelos/{marca_id}', 'ModelosController:show');
    



    $router->dispatch();

    
    if($router->error()){
        dd($router->error());
    }