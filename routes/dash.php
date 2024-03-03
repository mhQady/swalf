<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dash\LoginController;

Route::get('login', [LoginController::class, 'show'])->name('login');

Route::middleware('auth:admin')->group(function () {

    Route::view('/', 'dash.index')->name('home');

});



