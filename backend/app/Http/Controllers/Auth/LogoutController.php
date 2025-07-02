<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    /**
     * Выход пользователя (инвалидирует токен)
     *
     * @authenticated
     * @response 204 {}
     */
    public function logout(Request $request): JsonResponse
    {
        // Удаляем токен текущего пользователя
        $request->user()->currentAccessToken()->delete();

        // Возвращаем ответ в json
        return response()->json([
            'message' => 'Logged out successfully.'
        ]);
    }
}
