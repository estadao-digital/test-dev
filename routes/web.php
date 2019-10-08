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
////    return view('welcome');
//});

//Route::get('/', 'HomeController@index');

//Route::get('/clientes', 'ClientesController@clientes');
//Route::get('/clientes/novo', 'ClientesController@novo');
//Route::post('/clientes/salvar', 'ClientesController@salvar');

//Route::get('/login', function () {
    //return view('login');
//});

//Route::get('/dashboard', function () {
   // return view('dashboard');
//});


Auth::routes();

Route::get('/', 'HomeController@index')->name('clientes');
Route::get('/cruds', 'CrudController@index')->name('cruds');
Route::get('/cruds/novo', 'CrudController@novo')->name('novo');
Route::get('/cruds/{id}/editar', 'CrudController@editar')->name('editar');
Route::post('/cruds/salvar', 'CrudController@salvar')->name('salvar');
Route::post('/cruds/atualizar/{id}', 'CrudController@atualizar')->name('atualizar');
Route::post('/cruds/{id}', 'CrudController@deletar')->name('deletar');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
