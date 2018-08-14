<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});


Route::get('crudintro/datatable', 'CrudintroController@datatable');

Route::get('crudintro/modal', 'CrudintroController@modal');


Route::post('crudintro/carros', 'CrudintroController@carrosStore');

Route::delete('crudintro/carros', 'CrudintroController@carrosDelete');

Route::get('crudintro/carros/{id}', 'CrudintroController@getCarro');

Route::put('crudintro/carros/{id}', 'CrudintroController@carrosStore');




