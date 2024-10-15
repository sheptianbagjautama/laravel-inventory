<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Middleware\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('registration', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');

Route::middleware([Auth::class])->group(function () {
    Route::get('dashboard', [AuthController::class, 'dashboard']);
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
