<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly CommentService $commentService,
    )
    {
    }

    // Метод сохранения нового комментария
    public function store(StoreCommentRequest $request, Post $post)
    {
        // Создаем коммент, авторизованным юзером
        $this->commentService->create(
            $request->validated(),
            $post,
            Auth::user()
        );

        // Возвращаем перенаправление на страницу с постом и с сообщением об успехе
        return redirect()->route('posts.show', $post)->with('success', 'Новый комментарий добавлен!');
    }
}
