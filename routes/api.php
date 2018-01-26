<?php

use Illuminate\Http\Request;

// Route::prefix('v1')->group(function () {
    
//     Route::get('/carros', 'CarroController@index');
//     Route::post('/carros', 'CarroController@store');
//     Route::get('/carros/{id}', 'CarroController@show');
//     Route::put('/carros/{id}', 'CarroController@index');
//     Route::delete('/carros/{id}', 'CarroController@index');


// });

Route::resources([
    'v1/marcas' => 'MarcaController', 
    'v1/carros' => 'CarroController'
]);