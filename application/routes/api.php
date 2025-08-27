<?php

use App\Http\Controllers\CarController;
use App\Http\Controllers\CarMarkController;
use App\Http\Controllers\CarModelController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('register', [AuthController::class, 'register']); 
Route::post('login', [AuthController::class, 'login']);  

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', [AuthController::class, 'user']); 
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('car-marks', CarMarkController::class)->only(['index']);
    Route::apiResource('car-models', CarModelController::class)->only(['index']);

    Route::apiResource('cars', CarController::class);
    Route::get('cars/filters/filters', [CarController::class, 'filters']);
});
