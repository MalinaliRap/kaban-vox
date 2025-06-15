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

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/validate-token', [AuthController::class, 'validateToken'])->name('validate-token');

    Route::prefix('/boards')->group(function () {
        Route::get('/', [BoardController::class, 'index'])->name('boards.index');
        Route::post('/', [BoardController::class, 'store'])->name('boards.store');
        Route::get('/{board}', [BoardController::class, 'show'])->name('boards.show');
        Route::put('/{board}', [BoardController::class, 'update'])->name('boards.update');
        Route::delete('/{board}', [BoardController::class, 'destroy'])->name('boards.destroy');
    });
});
