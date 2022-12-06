<?php

use App\Http\Controllers\CarController;

Route::get('carros', [CarController::class, 'index']);
Route::post('carros', [CarController::class, 'store']);
Route::get('carros/{id}', [CarController::class, 'show']);
Route::put('carros/{id}', [CarController::class, 'update']);
Route::delete('carros/{id}', [CarController::class, 'destroy']);
