<nav class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">
        <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">Laravel Blog API</a>

        <div class="space-x-4">
            @guest
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Войти</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Регистрация</a>
            @else
                <span class="text-gray-700">Привет, {{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Выйти</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
