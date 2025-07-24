<form action="{{ $action }}" method="POST" class="mt-4 space-y-2">
    @csrf
    @if($method === 'PUT')
        @method('PUT')
    @endif

    <textarea name="body" rows="4" class="w-full p-2 border rounded"
              placeholder="Напишите комментарий...">{{ old('body', $comment->body ?? '') }}</textarea>

    @error('body')
    <p class="text-red-500 text-sm">{{ $message }}</p>
    @enderror

    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        {{ $submitButton }}
    </button>
</form>
