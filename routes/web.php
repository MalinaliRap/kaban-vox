<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    return Auth::check() ? view('boards.create') : view('auth.login');
});

Route::get('/boards/create', function () {
        return view('boards.create');
})->name('boards.create');
