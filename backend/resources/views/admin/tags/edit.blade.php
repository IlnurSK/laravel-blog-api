@extends('layouts.app')

@section('content')
    <div class="max-w-xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Редактировать тег</h1>

        @if($errors->any())
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.tags.update', $tag) }}" method="post">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-1">Название тега</label>
                <input type="text" name="name" id="name"
                       value="{{ old('name', $tag->name) }}"
                       class="w-full border border-gray-300 rounded px-4 py-2">
            </div>

            <div class="flex justify-between">
                <a href="{{ route('admin.tags.index') }}" class="text-gray-600 hover:underline">← Назад</a>
                <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                    Обновить
                </button>
            </div>
        </form>
    </div>
@endsection
