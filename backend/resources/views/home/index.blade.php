@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Последние посты</h1>

    <form method="GET" action="{{ route('home') }}" class="mb-6 flex flex-wrap gap-4 items-end">
        <div>
            <label for="category_id" class="block text-sm font-medium">Категория</label>
            <select name="category_id" id="category_id" class="border rounded p-1">
                <option value="">Все</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : ''}}>
                    {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="tag_ids" class="block text-sm font-medium">Теги</label>
            <select name="tag_ids[]" id="tag_ids" multiple class="border rounded p-1">
                @foreach($tags as $tag)
                    <option value="{{ $tag->id }}" {{ in_array($tag->id, (array)$tagIds) ? 'selected' : ''}}>
                        {{ $tag->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
            Фильтровать
        </button>
    </form>

    @forelse($posts as $post)
        <div class="bg-white shadow rounded p-4 mb-4">
            <h2 class="text-xl font-semibold">
                <a href="#">{{ $post->title }}</a>
            </h2>
            <p class="text-sm text-gray-600">Автор: {{ $post->user->name }} | Категория: {{ $post->$category->name ?? '-' }}</p>
            <div class="text-sm text-gray-500 mt-1">
                Теги:
                @foreach($post->tags as $tag)
                    <span class="bg-gray-200 px-2 py-0.5 rounded text-xs">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    @empty
        <p>Нет постов.</p>
    @endforelse

    {{ $posts->links() }}

@endsection
