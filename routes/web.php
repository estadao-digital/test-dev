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

Route::get('/carros', function () {
    return view('carros');
});


Route::get('/novo',function(){
    return view('novo');
});

Route::get('/edit/{id}','CarrosController@edit');