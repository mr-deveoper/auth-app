<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GoogleLoginController;
use App\Http\Controllers\LogoutController;

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
Route::get('/', function () {
    return view('home');
});

Route::get('auth/google', [GoogleLoginController::class, 'redirectToGoogle'])->name('loginWithGoogle');
Route::get('auth/google/callback', [GoogleLoginController::class, 'handleGoogleCallback'])->name('googleCallback');

Route::group(['middleware' => ['auth']], function () {
    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');
});
