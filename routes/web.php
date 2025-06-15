<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\BoardController;

use Illuminate\Support\Facades\Auth;
// Página de Login - Mostra o formulário de login
Route::get('/', [AuthController::class, 'showLoginForm'])->name('login.form');

// Dashboard - Para usuários logados
Route::get('/dashboard', [BoardController::class, 'index'])->name('dashboard');

// Logout - Para deslogar usuários
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');
