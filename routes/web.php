<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', fn() => redirect()->route('dash.home'))->name('home');
Route::view('/privacy', 'welcome')->name('privacy');
Route::view('/terms', 'welcome')->name('terms');

Route::get('/login', function () {
    return view('welcome');
})->name('login');
