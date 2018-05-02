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
Route::get('/', 'API\CarrosController@getCarrosView');
Route::get('/register', 'API\CarrosController@getMarcasView');
Route::get('/{id}', 'API\CarrosController@getCarroView');
