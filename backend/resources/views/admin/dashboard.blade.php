@extends('layouts.app')

@section('content')
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-4">Админ-панель</h1>

        <ul class="list-disc ml-5">
            <li><a href="{{ route('admin.categories.index') }}" class="text-blue-500 hover:underline">Категории</a></li>
            <li><a href="{{ route('admin.tags.index') }}" class="text-blue-500 hover:underline">Теги</a></li>
        </ul>
    </div>
@endsection
