@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4 text-center">Регистрация</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('register.perform') }}" method="post" class="space-y-4">
        <div>
            <label class="block text-sm font-medium">Имя</label>
            <input type="text" name="name" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Пароль</label>
            <input type="password" name="password" required class="w-full border px-3 py-2 rounded">
        </div>

        <div>
            <label class="block text-sm font-medium">Повторите пароль</label>
            <input type="password" name="password_confirmation" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-2 rounded">
            Зарегистрироваться
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('login') }}" class="text-sm text-blue-600 hover:underline">Уже есть аккаунт?</a>
    </div>
@endsection
