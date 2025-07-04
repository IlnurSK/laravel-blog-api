@extends('layouts.app')

@section('content')
    <h2 class="text-2xl font-bold mb-4 text-center">Вход</h2>

    @if(session('error'))
        <div class="bg-red-100 text-red-700 p-2 rounded mb-4">{{ session('error') }}</div>
    @endif

    <form action="{{ route('login.perform') }}" method="post" class="space-y-4">

        <div>
            <label class="block text-sm font-medium">Email</label>
            <input type="email" name="email" required class="w-full border px-3 py-2 rounded">
        </div>

        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded">
            Войти
        </button>
    </form>

    <div class="text-center mt-4">
        <a href="{{ route('register') }}" class="text-sm text-blue-600 hover:underline">Нет аккаунта?</a>
    </div>
@endsection
