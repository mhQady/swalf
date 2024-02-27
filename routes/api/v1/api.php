<?php

use App\Http\Controllers\Api\V1\CountriesController;
use App\Http\Controllers\Api\V1\InterestsController;
use Illuminate\Http\Request;
use App\Services\OTP\OtpSender;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\CompleteDataController;


Route::middleware('guest:sanctum')->group(function () {
    Route::post('register/enter-phone', [RegisterController::class, 'enterPhone']);
    Route::post('register/verify-phone', [RegisterController::class, 'verifyPhone']);
    Route::post('register/enter-password', [RegisterController::class, 'enterPassword']);

    Route::post('login', LoginController::class);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/send-otp', function (Request $request) {
        OtpSender::send(request()->user(), 1, __('main.sent.otp'));
    });
    Route::get('countries', CountriesController::class);
    Route::get('interests', InterestsController::class);
    Route::post('logout', LogoutController::class);

    Route::post('complete-data/enter-personal-info', [CompleteDataController::class, 'enterPersonalInfo']);
    Route::post('complete-data/enter-country', [CompleteDataController::class, 'enterCountry']);
    Route::post('complete-data/enter-interests', [CompleteDataController::class, 'enterInterests']);
});
