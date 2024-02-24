<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\RegisterController;


Route::middleware('guest:sanctum')->group(function () {
    Route::post('register/enter-phone', [RegisterController::class, 'enterPhone']);
    Route::post('register/verify-phone', [RegisterController::class, 'verifyPhone']);
    Route::post('register/enter-password', [RegisterController::class, 'enterPassword']);

    Route::post('login', LoginController::class);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('test', function () {
    return 'test successful';
});
