<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

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
    public function register(Request $request)
    {
        // Отправляем данные регистрации на API
        $response = Http::post(config('app.url') . '/api/register',
            $request->only('name', 'email', 'password', 'password_confirmation'));

        // В случае успеха добавляем токен в сессию и отправляем на страницу с постами
        if ($response->successful()) {
            Session::put('token', $response['token']);
            return redirect('/posts');
        }

        // В случае ошибки возвращаем на прошлую страницу с сообщением
        return back()->with('error', 'Registration failed');
    }

    /**
     * @throws ConnectionException
     */
    // Метод авторизации (логина)
    public function login(Request $request)
    {
        // Отправляем данные авторизации на API
        $response = Http::post(config('app.url') . '/api/login',
            $request->only('email', 'password'));

        // В случае успеха добавляем токен в сессию и отправляем на страницу с постами
        if ($response->successful()) {
            Session::put('token', $response['token']);
            return redirect('/posts');
        }

        // В случае ошибки возвращаем на прошлую страницу с сообщением
        return back()->with('error', 'Invalid credentials');
    }

    // Метод выхода из системы (логаут)
    public function logout(Request $request)
    {
        // Отправляем токен сессии на API логаута
        Http::withToken(Session::get('token'))->post(config('app.url') . '/api/logout');

        // Удаляем токен из сессии
        Session::forget('token');

        // Перенаправляем на страницу логина
        return redirect('/login');
    }
}
