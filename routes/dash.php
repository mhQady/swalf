<?php

use Illuminate\Support\Facades\Route;

Route::view('login', 'auth.login')->name('login');

Route::middleware('auth:admin')->group(function () {

    Route::view('/', 'dash.index')->name('home');

});



