<?php

$app->options('{routes:.+}', function ($request, $response, $args) {
    return $response;
});

$app->group('/v1', function() {
	 
    $this->group('/carros', function() {
        $this->get('', '\App\v1\Controllers\CarrosController:listCarros');
        $this->post('', '\App\v1\Controllers\CarrosController:createCarro');
        $this->get('/{id:[0-9]+}', '\App\v1\Controllers\CarrosController:listCarro');
        $this->put('/{id:[0-9]+}', '\App\v1\Controllers\CarrosController:updateCarro');
        $this->delete('/{id:[0-9]+}', '\App\v1\Controllers\CarrosController:deleteCarro');
    });

    $this->group('/marcas', function() {
        $this->get('', '\App\v1\Controllers\MarcasController:listMarcas');
    });
});

$app->get('/', function ($request, $response, $args) {
    return $this->view->render($response, 'index.html');
})->setName('index'); 