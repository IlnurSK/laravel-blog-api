<?php

use App\Http\Controllers\Web\AuthController;
use Illuminate\Support\Facades\Route;

// Маршрут получения формы логина
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
// Маршрут отправки данных на форму логина
Route::post('/login', [AuthController::class, 'login'])->name('login.perform');

// Маршрут получения формы регистрации
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
// Маршрут отправки данных на форму регистрации
Route::post('/register', [AuthController::class, 'register'])->name('register.perform');

// Маршрут выхода из системы
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

