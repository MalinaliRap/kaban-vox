<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;
Route::get('/', [App\Http\Controllers\API\AuthController::class, 'index'])->name('index');
Route::get('/login', [App\Http\Controllers\API\AuthController::class, 'index'])->name('login');
Route::post('/login', [App\Http\Controllers\API\AuthController::class, 'login']);

Route::prefix('boards')->group(function () {
    Route::get('/create', [App\Http\Controllers\API\BoardController::class, 'create'])->name('boards.create');
});
