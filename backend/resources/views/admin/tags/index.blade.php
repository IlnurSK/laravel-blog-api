@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto p-4">
        <h1 class="text-2xl font-bold mb-4">Теги</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 flex justify-between">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:underline">← Назад</a>
            <a href="{{ route('admin.tags.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                + Добавить тег
            </a>
        </div>

        <table class="w-full border-collapse">
            <thead>
            <tr class="bg-gray-100 text-left">
                <th class="border px-4 py-2">ID</th>
                <th class="border px-4 py-2">Название</th>
                <th class="border px-4 py-2">Действие</th>
            </tr>
            </thead>

            <tbody>
            @forelse($tags as $tag)
                <tr>
                    <td class="border px-4 py-2">{{ $tag->id }}</td>
                    <td class="border px-4 py-2">{{ $tag->name }}</td>
                    <td class="border px-4 py-2 flex gap-2">
                        <a href="{{ route('admin.tags.edit', $tag) }}" class="text-blue-600 hover:underline">Редактировать</a>

                        <form action="{{ route('admin.tags.destroy', $tag) }}" method="post" onsubmit="return confirm('Удалить тег?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">Удалить</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="border px-4 py-2 text-center text-gray-500">Тегов пока нет</td>
                </tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
