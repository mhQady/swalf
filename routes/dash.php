<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\LoginController;


Route::middleware('guest:admin')->group(function () {

    Route::get('login', [LoginController::class, 'show'])->name('login');
    Route::post('authenticate', [LoginController::class, 'authenticate'])->name('authenticate');

});

Route::middleware('auth:admin')->group(function () {

    Route::get('logout', [LoginController::class, 'logout'])->name('logout');

    Route::view('/', 'dash.index')->name('home');

    Route::post('chat', function ($user) {
        return Auth::check();
    });

    Route::resources([
        'roles' => \App\Http\Controllers\Dash\RoleController::class,
        'admins' => \App\Http\Controllers\Dash\AdminController::class,
        'countries' => \App\Http\Controllers\Dash\CountryController::class,
        'cities' => \App\Http\Controllers\Dash\CityController::class,
        'interests' => \App\Http\Controllers\Dash\InterestController::class,
    ], ['except' => ['show']]);

});



