@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto mt-8">
        <h1 class="text-2xl font-bold mb-4">Мои посты</h1>

        @foreach($posts as $post)
            <div class="bg-white rounded shadow p-4 mb-4">
                <h2 class="text-xl font-semibold">
                    <a href="{{ route('posts.show', $post) }}" class="text-blue-600 hover:underline">
                        {{ $post->title }}
                    </a>
                </h2>
                <p class="text-sm text-gray-600">
                    {{ $post->created_at->format('d.m.Y') }} • Категория: {{ $post->category->name ?? 'Без категории' }}
                </p>
                <div class="flex gap-2 mt-2">
                    @foreach($post->tags as $tag)
                        <span class="text-xs bg-gray-200 rounded px-2 py-1">{{ $tag->name }}</span>
                    @endforeach
                </div>
                <div class="mt-4 flex gap-3">
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
