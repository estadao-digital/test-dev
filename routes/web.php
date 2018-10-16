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

Route::get('/', function () {
    return view('welcome');
});

/** 
* @author Vitor Caetano <vitor.caetano.silva@usp.br>
* @since 10-16-2018
**/

Route::prefix('carros')->group(function () {

	//HOME
    Route::get('/', 'Carros\CarrosController@get');
    Route::post('/', 'Carros\CarrosController@post');

    //EDIT
    Route::get('detail/{id}', 'Carros\CarrosController@get');

    //APPLY
    Route::post('delete/{id}', 'Carros\CarrosController@delete');
    Route::post('edit/{id}', 'Carros\CarrosController@edit');


    Route::get('spa', 'Carros\CarrosController@spa');
});
