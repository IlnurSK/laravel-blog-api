<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TagController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Маршрут регистрации нового пользователя
Route::post('/register', [RegisterController::class, 'register']);
// Маршрут авторизации пользователя
Route::post('/login', [LoginController::class, 'login']);
// Маршрут выхода из системы, авторизованного пользователя
Route::post('/logout', [LogoutController::class, 'logout'])->middleware('auth:sanctum');


// Маршрут получения всех Постов
Route::get('/posts', [PostController::class, 'index']);
// Маршрут получения конкретного Поста
Route::get('/posts/{post}', [PostController::class, 'show']);
// Маршрут создания нового Поста, авторизованного пользователя
Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
// Маршрут обновления Поста, авторизованного пользователя
Route::put('/posts/{post}', [PostController::class, 'update'])->middleware('auth:sanctum');
// Маршрут удаления Поста, авторизованного пользователя
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->middleware('auth:sanctum');


// Ресурсный маршрут для Категорий
Route::apiResource('/categories', CategoryController::class);

// Ресурсный маршрут для Тегов
Route::apiResource('/tags', TagController::class);
