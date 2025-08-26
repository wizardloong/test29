<?php

use App\Http\Controllers\CarMarkController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/tokens/create', function (Request $request) {
    $token = $request->user()->createToken($request->token_name);
    // Тут можно было бы описать абилки пользователя
    // Но в нашей маленькой системе это будет избыточно
    // Стоит добавлять абилки, когда в системе больше одного пользовательского пути

    return ['token' => $token->plainTextToken];
});

Route::apiResource('car-marks', CarMarkController::class)->only(['index']);

