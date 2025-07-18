<?php

use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PostController;
use Illuminate\Support\Facades\Route;

// Маршрут стартовой страницы
Route::get('/', [HomeController::class, 'index'])->name('home');

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

Route::middleware(['auth'])->group(function () {
    // Маршрут для отображения формы создания нового поста
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    //Маршрут для сохранения нового поста
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    // Маршрут для отображения страницы со всеми постами юзера
    Route::get('/my-posts', [PostController::class, 'mine'])->name('posts.mine');
    // Маршрут для отображения формы редактирования поста
    Route::get('/posts/{post}/edit', [PostController::class, 'showEdit'])->name('posts.edit');
    // Маршрут обновления поста
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    //Маршрут для удаления поста
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

});

// Маршрут для отображения поста
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
