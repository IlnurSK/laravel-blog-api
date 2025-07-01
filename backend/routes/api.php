<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Публичные маршруты

// Маршрут регистрации нового пользователя
Route::post('/register', [RegisterController::class, 'register']);
// Маршрут авторизации пользователя
Route::post('/login', [LoginController::class, 'login']);

// Маршрут получения всех Постов
Route::get('/posts', [PostController::class, 'index']);
// Маршрут получения конкретного Поста
Route::get('/posts/{post}', [PostController::class, 'show']);

// Маршрут получения всех Категорий
Route::get('/categories', [CategoryController::class, 'index']);
// Маршрут получения Постов по Категориям
Route::get('/categories/{category}/posts', [CategoryController::class, 'posts']);

// Маршрут получения всех Тегов
Route::get('/tags', [TagController::class, 'index']);
// Маршрут получения Постов по Тегам
Route::get('/tags/{tag}/posts', [TagController::class, 'posts']);

// Маршрут получения всех Комментов к Посту
Route::get('/posts/{post}/comments', [CommentController::class, 'index']);
// Маршрут получения конкретного коммента к Посту
Route::get('/posts/{post}/comments/{comment}', [CommentController::class, 'show']);


// Защищенные маршруты

Route::middleware('auth:sanctum')->group(function () {
    // Маршрут выхода из системы, авторизованного пользователя
    Route::post('/logout', [LogoutController::class, 'logout']);

    // CRUD Постов
    // Маршрут создания нового Поста
    Route::post('/posts', [PostController::class, 'store']);
    // Маршрут обновления Поста
    Route::put('/posts/{post}', [PostController::class, 'update']);
    // Маршрут удаления Поста
    Route::delete('/posts/{post}', [PostController::class, 'destroy']);

    // CRUD Комментариев
    // Маршрут создания нового Коммента
    Route::post('/posts/{post}/comments', [CommentController::class, 'store']);
    // Маршрут обновления Коммента
    Route::put('/posts/{post}/comments/{comment}', [CommentController::class, 'update']);
    // Маршрут удаления Коммента
    Route::delete('/posts/{post}/comments/{comment}', [CommentController::class, 'destroy']);


    // Категории - только админ
    Route::middleware('admin')->group(function () {
        // CRUD Категорий
        // Маршрут создания Категории
        Route::post('/categories', [CategoryController::class, 'store']);
        // Маршрут обновления Категории
        Route::put('/categories/{category}', [CategoryController::class, 'update']);
        // Маршрут удаления Категории
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

        // CRUD Тегов
        // Маршрут создания Тега
        Route::post('/tags', [TagController::class, 'store']);
        // Маршрут обновления Тега
        Route::put('/tags/{tag}', [TagController::class, 'update']);
        // Маршрут удаления Тега
        Route::delete('/tags/{tag}', [TagController::class, 'destroy']);
    });
});

