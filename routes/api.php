<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BoardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api')->name('logout');

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'user'])->name('user.show');
});
