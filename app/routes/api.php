<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CarController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('cars', 'App\Http\Controllers\CarController');
Route::resource('brands', 'App\Http\Controllers\BrandController');
Route::post('upload/car/{id}', [CarController::class, 'upload']);
/*
->missing(function(Request request){
    return response()->json([
        'success' => false,
        'message' => 'Rota inválida.',
    ]);
});*/
