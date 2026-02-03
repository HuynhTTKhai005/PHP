<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;

// Giao diện login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Xử lý login
Route::post('/login', [AuthController::class, 'login']);
// Xử lý logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');