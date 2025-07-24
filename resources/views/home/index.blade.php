@extends('layouts.app')

@section('title', 'Главная страница')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-4 rounded shadow-lg mb-3">
        <h1 class="text-2xl font-bold mb-2">Последние посты</h1>

        <form method="GET" action="{{ route('home') }}" class="flex flex-wrap gap-2 items-end">
            <div>
                <label for="category_id" class="block text-sm font-medium">Категория</label>
                <select name="category_id" id="category_id" class="text-sm  border rounded p-1">
                    <option value="">Все</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $categoryId == $category->id ? 'selected' : ''}}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <p class="block text-sm font-medium mb-1">Теги</p>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center space-x-2 text-sm">
                            <input
                                type="checkbox"
                                name="tag_ids[]"
                                value="{{ $tag->id }}"
                                {{ in_array($tag->id, (array) $tagIds) ? 'checked' : '' }}
                                class="form-checkbox text-blue-600"
                            >
                            <span>{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                Фильтровать
            </button>
        </form>
    </div>


    @forelse($posts as $post)
        <div class="max-w-3xl mx-auto bg-white p-4 rounded shadow-lg mb-4">
            <h2 class="text-xl font-semibold mb-2">
                <a href="{{ route('posts.show', $post->id) }}" class="text-blue-600 hover:underline">
                    {{ $post->title }}
                </a>
            </h2>

            <p class="text-sm text-gray-600 mb-2">
                Автор: {{ $post->user->name }} | Категория: {{ $post->category->name ?? 'Без категории' }}
            </p>

            <p class="text-gray-800">{{ \Illuminate\Support\Str::limit($post->body, 150) }}</p>

            @if($post->tags->isNotEmpty())
                <div class="mt-2 flex flex-wrap gap-1">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('home', ['tag_ids[]' => $tag->id]) }}"
                        class="text-sm text-blue-600 hover:bg-blue-400 hover:text-white bg-gray-200 px-2 py-1 rounded">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

        </div>
    @empty
        <p>Нет постов.</p>
    @endforelse

    {{ $posts->links() }}

@endsection
