<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('carros', '\App\Api\v1\Cars\CarsEndpoint@getAllCars');
Route::get('carros/{id}', '\App\Api\v1\Cars\CarsEndpoint@getCarById');
Route::post('carros', '\App\Api\v1\Cars\CarsEndpoint@store');
Route::put('carros/{id}', '\App\Api\v1\Cars\CarsEndpoint@update');
Route::delete('carros/{id}', '\App\Api\v1\Cars\CarsEndpoint@destroy');