<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Вход пользователя
     *
     * @bodyParam email string required Email пользователя. Example: user@example.com
     * @bodyParam password string required Пароль. Example: password123
     *
     * @response 200 {
     *   "token": "..."
     * }
     */
    public function login(LoginRequest $request): JsonResponse
    {
        // Проверка учетных данных
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'message' => 'Invalid credentials.'
            ], 401);
        }

        // Получаем авторизованного пользователя, и его токен
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        // Возвращаем ответ в json
        return response()->json([
            'message' => 'Login successful.',
            'access_token' => $token,
            'token_type' => 'Bearer',
        ]);
    }
}
