<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('login');
});

Route::get('/boards/create', function () {
        return view('boards.create');
})->name('boards.create');
