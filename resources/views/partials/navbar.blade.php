<nav class="bg-white shadow">
    <div class="container mx-auto px-4 py-4 flex justify-between items-center">

        <div class="space-x-4">
            <a href="{{ route('home') }}" class="text-xl font-bold text-blue-600">Laravel Blog API</a>
            <a href="{{ auth()->check() ? route('posts.mine') : route('login') }}"
               class="text-blue-500 hover:underline">Мои посты</a>
            <a href="{{ auth()->check() ? route('posts.create') : route('login') }}"
            class="text-blue-500 hover:underline">Создать новый пост</a>
        </div>

        <div class="space-x-4">
            @auth
                @if(auth()->user()->is_admin)
                    <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">Админ-панель</a>
                @endif
            @endauth

            @guest
                <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Войти</a>
                <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Регистрация</a>
            @else
                <span class="text-gray-700">{{ \Illuminate\Support\Facades\Auth::user()->name }}</span>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-red-600 hover:underline">Выйти</button>
                </form>
            @endguest
        </div>
    </div>
</nav>
