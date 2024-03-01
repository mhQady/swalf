<?php

use App\Http\Controllers\Api\V1\CountriesController;
use App\Http\Controllers\Api\V1\ForgotPasswordController;
use App\Http\Controllers\Api\V1\InterestsController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Resources\UserResource;
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

    Route::post('forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp']);
    Route::post('forgot-password/confirm-otp', [ForgotPasswordController::class, 'confirmOtp']);
    Route::post('forgot-password/change-password', [ForgotPasswordController::class, 'changePassword']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return new UserResource($request->user()->load('country'));
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

    Route::post('profile/update', [ProfileController::class, 'update']);
});
