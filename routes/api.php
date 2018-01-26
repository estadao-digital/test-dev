<?php

use Illuminate\Http\Request;

Route::resources([
    'v1/marcas' => 'MarcaController', 
    'v1/carros' => 'CarroController'
]);