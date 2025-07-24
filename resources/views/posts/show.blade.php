@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-4 rounded shadow-lg">
        <div class="mb-6">
            <h1 class="text-2xl font-bold"{{ $post->title }}></h1>
            <p class="text-gray-600 text-sm">
                Автор: {{ $post->user->name }} |
                Категория: {{ $post->category->name ?? 'Без категории' }} |
                {{ $post->created_at->translatedFormat('d M Y H:i') }}
            </p>
        </div>

        <div class="prose max-w-none">
            {!! nl2br(e($post->body)) !!}
        </div>

        @if($post->tags->isNotEmpty())
            <div class="mt-4">
                <p class="font-semibold">Теги:</p>
                <div class="flex flex-wrap gap-2 mt-1">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('home', ['tag_ids[]' => $tag->id]) }}"
                           class="text-sm text-blue-600 hover:bg-blue-400 hover:text-white bg-gray-200 px-2 py-1 rounded">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <hr class="my-6">

        @include('comments.index', ['comments' => $post->comments])



        @if(auth()->check())
            <h3 class="text-lg font-semibold mt-6">Оставить комментарий:</h3>

            @include('comments.form', [
        'action' => route('comments.store', $post),
        'method' => 'POST',
        'submitButton' => 'Отправить',
        'comment' => null
    ])
        @else
            <p class="mt-4">
                <a href="{{ route('login') }}" class="text-blue-500 hover:underline">Войдите</a>, чтобы оставить комментарий.
            </p>
        @endif
    </div>
@endsection
