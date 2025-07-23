@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Мои посты</h1>

        @foreach($posts as $post)
            <div class="bg-white rounded shadow-lg p-4 mb-4">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-sm text-gray-600">
                    {{ $post->created_at->format('d.m.Y') }} • Категория: {{ $post->category->name ?? 'Без категории' }} • Статус: {{ $post->is_published ? 'Опубликовано' : 'Не опубликовано' }}
                </p>
                <div class="flex gap-2 mt-2">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('home', ['tag_ids[]' => $tag->id]) }}"
                           class="text-sm text-blue-600 hover:bg-blue-400 hover:text-white bg-gray-200 px-2 py-1 rounded">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
                <div class="mt-4 flex gap-3">
                    @if(!$post->is_published)
                        <form action="{{ route('posts.publish', $post->id) }}" method="POST" onsubmit="return confirm('Опубликовать пост?')">
                            @csrf
                            <button type="submit" class="text-blue-500 hover:underline">Опубликовать</button>
                        </form>
                    @endif

                    <a href="{{ route('posts.edit', $post) }}" class="text-blue-500 hover:underline">Редактировать</a>

                    <form action="{{ route('posts.destroy',$post) }}" method="POST" onsubmit="return confirm('Удалить пост?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-500 hover:underline">Удалить</button>
                    </form>
                </div>
            </div>
        @endforeach

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
@endsection
