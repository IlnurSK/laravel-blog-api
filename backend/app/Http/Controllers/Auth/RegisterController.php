<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    /**
     * Регистрация нового пользователя
     *
     * @bodyParam name string required Имя пользователя. Example: John Doe
     * @bodyParam email string required Email. Example: john@example.com
     * @bodyParam password string required Пароль (мин. 8 символов). Example: password123
     * @bodyParam password_confirmation string required Подтверждение пароля. Example: password123
     */
    // Метод регистрации
    public function register(RegisterRequest $request): JsonResponse
    {
        // Создаем нового пользователя
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Создаем токен
        $token = $user->createToken('auth_token')->plainTextToken;

        // Возвращаем ответ в json
        return response()->json([
            'message'      => 'User registered successfully.',
            'access_token' => $token,
            'token_type'   => 'Bearer',
        ]);
    }
}
