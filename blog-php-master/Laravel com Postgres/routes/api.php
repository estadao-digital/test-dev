<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
Route::get('users', function() {
    return 'Funcionando!!!';
});
*/

Route::get('users', "UsersController@index");
Route::post('users', "UsersController@store");
Route::patch('users/{user}', "UsersController@update");
Route::delete('users/{user}', "UsersController@remove");