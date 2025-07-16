@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Создать пост</h1>

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('posts.store') }}" method="post">
            @csrf
            <div class="mb-4">
                <label class="block font-medium mb-1">Заголовок</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="w-full border border-gray-300 rounded px-3 py-2">
                @error('title')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Текст</label>
                <textarea name="body" rows="5"
                          class="w-full border border-gray-300 rounded px-3 py-2">{{ old('body') }}</textarea>
                @error('body')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Категория</label>
                <select name="category_id" class="w-full border border-gray-300 rounded px-3 py-2">
                    <option value="">-- Без категории --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : ''}}>
                        {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block font-medium mb-1">Теги</label>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="tag_ids[]" value="{{ $tag->id }}"
                            {{ in_array($tag->id, old('tag_ids', [])) ? 'checked' : '' }}>
                            <span class="ml-2">{{ $tag->name }}</span>
                        </label>
                    @endforeach
                </div>
                @error('tag_ids')
                <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}>
                    <span class="ml-2">Опубликовать сейчас</span>
                </label>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-600">
                Создать пост
            </button>
        </form>
    </div>
@endsection
