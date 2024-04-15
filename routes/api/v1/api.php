<?php

use App\Http\Controllers\Api\V1\ReportController;
use App\Http\Controllers\Api\V1\SocialLoginController;
use Illuminate\Http\Request;
use App\Services\OTP\OtpSender;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ChatController;
use App\Http\Controllers\Api\V1\HomeController;
use App\Http\Controllers\Api\V1\LoginController;
use App\Http\Controllers\Api\V1\LogoutController;
use App\Http\Controllers\Api\V1\ProductController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\RegisterController;
use App\Http\Controllers\Api\V1\CountriesController;
use App\Http\Controllers\Api\V1\InterestsController;
use App\Http\Controllers\Api\V1\CompleteDataController;
use App\Http\Controllers\Api\V1\MediaUploaderController;
use App\Http\Controllers\Api\V1\ForgotPasswordController;


Route::middleware('guest:sanctum')->group(function () {
    Route::post('register/enter-phone', [RegisterController::class, 'enterPhone']);
    Route::post('register/verify-phone', [RegisterController::class, 'verifyPhone']);
    Route::post('register/enter-password', [RegisterController::class, 'enterPassword']);

    Route::post('login', LoginController::class);

    Route::post('forgot-password/send-otp', [ForgotPasswordController::class, 'sendOtp']);
    Route::post('forgot-password/confirm-otp', [ForgotPasswordController::class, 'confirmOtp']);
    Route::post('forgot-password/change-password', [ForgotPasswordController::class, 'changePassword']);

    Route::get('login/social/{driver?}', [SocialLoginController::class, 'redirectToGoogle']);

    Route::get('login/google/callback', [SocialLoginController::class, 'handleGoogleCallback']);
});

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return new UserResource($request->user()->load('market'));
    });

    Route::post('/send-otp', function (Request $request) {
        OtpSender::send(request()->user(), 1, __('main.sent.otp'));
    });

    Route::post('media/upload', [MediaUploaderController::class, 'uploadFile']);
    Route::delete('media/{media}', [MediaUploaderController::class, 'deleteFile']);

    Route::get('countries', [CountriesController::class, 'index']);
    Route::get('countries/{country}/cities', [CountriesController::class, 'getCities']);
    Route::get('interests', [InterestsController::class, 'index']);
    Route::post('logout', LogoutController::class);

    Route::post('complete-data/enter-personal-info', [CompleteDataController::class, 'enterPersonalInfo']);
    Route::post('complete-data/enter-country', [CompleteDataController::class, 'enterCountry']);
    Route::post('complete-data/enter-interests', [CompleteDataController::class, 'enterInterests']);

    Route::post('profile/update', [ProfileController::class, 'update']);
    Route::delete('profile/delete', [ProfileController::class, 'delete']);
    Route::post('profile/change-market', [ProfileController::class, 'changeMarket']);

    Route::get('chats', [ChatController::class, 'index']);
    Route::get('chats/{chat}', [ChatController::class, 'show']);
    Route::post('chats/start', [ChatController::class, 'startChat']);
    Route::post('chats/{chat}/send-message/', [ChatController::class, 'sendMessage']);

    Route::get('reports/types', [ReportController::class, 'getReportTypes']);
    Route::post('reports/send', [ReportController::class, 'send']);

    Route::apiResource('products', ProductController::class);

    Route::get('user/products/suggested', [HomeController::class, 'getSuggestedProducts']);
    Route::get('user/interests', [HomeController::class, 'getUserInterests']);
    Route::get('search', [HomeController::class, 'search']);

});
