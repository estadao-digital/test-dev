<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Carro;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/carro/{id?}',[Carro::class, "index"]);
Route::post('/carro',[Carro::class, "insert"]);
Route::post('/carro/delete',[Carro::class, "delete"]);
Route::post('/carro/{id}',[Carro::class, "update"]);
