<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? view('boards.create') : view('auth.login');
});

Route::prefix('boards')->group(function () {
    Route::get('/create', [App\Http\Controllers\API\BoardController::class, 'create'])->name('boards.create');
});
