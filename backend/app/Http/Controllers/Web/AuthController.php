<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Метод вызова представления формы регистрации
    public function showRegister()
    {
        return view('auth.register');
    }

    // Метод вызова представления формы логина
    public function showLogin()
    {
        return view('auth.login');
    }

    /**
     * @throws ConnectionException
     */
    // Метод Регистрации
    public function register(RegisterRequest $request)
    {
        // Создаем нового пользователя
        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Авторизуем его в сессию
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Регистрация прошла успешно!');
    }

    // Метод авторизации (логина)
    public function login(LoginRequest $request)
    {
        // Проверка учетных данных
        if (Auth::attempt($request->validated())) {
            $request->session()->regenerate();

            return redirect()->route('home')->with('success', 'Вы вошли в систему');
        }

        return back()->withErrors(['email' => 'Неверные данные'])->withInput();
    }

    // Метод выхода из системы (логаут)
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'Вы вышли из аккаунта.');
    }
}
