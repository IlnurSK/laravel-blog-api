<h2 class="text-xl font-bold mb-4">Комментарии ({{ $comments->count() }})</h2>

@if($comments->isEmpty())
    <p class="text-gray-600">Комментариев пока нет.</p>
@else
    <div class="space-y-4">
        @foreach($comments as $comment)
            <div class="p-3 border rounded bg-gray-50">
                <p class="text-sm text-gray-700 mb-1">{{ $comment->user->name }} написал:</p>
                <p>{{ $comment->body }}</p>
                <p class="text-xs text-gray-500 mt-1">{{ $comment->created_at->diffForHumans() }}</p>
            </div>
        @endforeach
    </div>
@endif
