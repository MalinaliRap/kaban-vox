<?php

use App\Http\Controllers\API\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
*/

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login'])->name('login');

Route::middleware('auth:api')->group(function () {
    Route::get('user', [AuthController::class, 'user'])->name('user.show');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    //board routes
    Route::prefix('boards')->group(function () {
        Route::post('/', [App\Http\Controllers\API\BoardController::class, 'store'])->name('boards.store');
        Route::put('/{id}', [App\Http\Controllers\API\BoardController::class, 'update'])->name('boards.update');
        Route::delete('/{id}', [App\Http\Controllers\API\BoardController::class, 'destroy'])->name('boards.destroy');
    });
});
