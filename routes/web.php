<?php

use App\Http\Controllers\Web\AdminController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CategoryController;
use App\Http\Controllers\Web\CommentController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\PostController;
use App\Http\Controllers\Web\TagController;
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

// Группа маршрутов для админов
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Маршрут отображения админ панели
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    // Ресурсный маршрут для категорий
    Route::resource('categories', CategoryController::class)->except(['show']);
    // Ресурсный маршрут для тегов
    Route::resource('tags', TagController::class)->except(['show']);

});

// Группа маршрутов для авторизованных пользователей
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
    // Маршрут для удаления поста
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    // Маршрут для публикации поста
    Route::post('/posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
    // Маршрут для создания нового комментария
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');
    // Маршрут для отображения формы редактирования комментария
    Route::get('/posts/{post}/comments/{comment}/edit', [CommentController::class, 'showEdit'])->name('comments.edit');
    // Маршрут для обновления комментария
    Route::put('/posts/{post}/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');
    // Маршрут удаления Коммента
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

});

// Маршрут для отображения поста
Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
