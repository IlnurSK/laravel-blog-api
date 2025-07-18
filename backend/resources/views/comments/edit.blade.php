@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-4 shadow rounded">
    <h2 class="text-2xl font-bold mb-4">Редактировать комментарий</h2>

    <form method="POST" action="{{ route('comments.update', [$comment->post, $comment]) }}">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="body" class="block text-sm font-medium text-gray-700">Текст комментария</label>
            <textarea name="body" id="body" rows="4"
            class="w-full border rounded px-3 py-2" required>{{ old('body', $comment->body) }}</textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Сохранить
        </button>
    </form>
</div>
@endsection
