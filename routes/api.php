<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/register', RegisterController::class)->name('register');
Route::post('/login', LoginController::class)->name('login');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    try {
        return $request->user();
    } catch (Exception $ex) {
        return response()->json($ex);
    }
});

Route::post('/logout', LogoutController::class)->name('logout');


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
