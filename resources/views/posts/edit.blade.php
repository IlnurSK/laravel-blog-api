@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow-lg">
        <h1 class="text-2xl font-bold mb-4">Редактировать пост</h1>

        <form action="{{ route('posts.update', $post->id) }}" method="post">
            @csrf
            @method('PATCH')

            <div class="mb-4">
                <label class="block font-semibold mb-1">Заголовок</label>
                <input type="text" name="title" value="{{ old('title', $post->title) }}"
                class="w-full border rounded px-3 py-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Текст поста</label>
                <textarea name="body" class="w-full border rounded px-3 py-2" rows="6" required>{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Категория</label>
                <select name="category_id" class="w-full border rounded px-3 py-2">
                    <option value="">Без категории</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}"
                        {{ old('category_id', $post->category_id) == $category->id ? 'selected' : ''}}>
                        {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Теги</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tag_ids[]"
                            value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tag_ids', $post->tags->pluck('id')->toArray())) ? 'checked' : '' }}
                            class="mr-1">
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-4">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Обновить</button>
            </div>
        </form>
    </div>
@endsection
