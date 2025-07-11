@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <h1 class="text-2xl font-bold mb-6">Последние посты</h1>

    @forelse($posts as $post)
        <div class="bg-white p-6 rounded shadow mb-6">
            <h2 class="text-xl font-semibold text-blue-600">{{ $post['title'] }}</h2>
            <p class="text-gray-600 text-sm mb-2">
                Автор: {{ $post['user']['name'] ?? 'Неизвестно' }} |
                Категория: {{ $post['category']['name'] ?? 'Без категории' }} |
                {{ \Carbon\Carbon::parse($post['created_at'])->translatedFormat('d M Y H:i') }}
            </p>
            <div class="mb-2">
                @foreach($post['tags'] as $tag)
                    <span class="inline-block bg-gray-200 text-sm text-gray-700 px-2 py-1 rounded mr-2">#{{ $tag['name'] }}</span>
                @endforeach
            </div>
            <a href="#" class="text-blue-500 hover:underline">Читать далее</a>
        </div>
    @empty
        <p>Постов пока нет.</p>
    @endforelse
@endsection
