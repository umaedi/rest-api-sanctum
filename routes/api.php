<?php

use App\Http\Controllers\API\ContactController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register')->name('register');
    Route::post('/login', 'authenticate')->name('authenticate');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('/contact', ContactController::class);

    Route::post('/logout', [AuthController::class, 'destroy']);
});
