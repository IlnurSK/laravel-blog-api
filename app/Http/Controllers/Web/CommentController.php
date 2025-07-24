<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly CommentService $commentService,
    ) {
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

    // Метод отображения формы редактирования комментария
    public function showEdit(Post $post, Comment $comment)
    {
        return view('comments.edit', compact('post', 'comment'));
    }

    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        // Проверяем является ли юзер владельцем
        $this->authorize('update', $comment);

        $this->commentService->update($comment, $request->validated());

        // Перенаправляем на страницу с постом и с сообщением об обновлении
        return redirect()->route('posts.show', $post)->with('success', 'Комментарий обновлён!');

    }

    public function destroy(Post $post, Comment $comment)
    {
        // Проверяeм является ли юзер владельцем коммента
        $this->authorize('delete', $comment);

        // Удаляем Коммент
        $this->commentService->delete($comment);

        // Возвращаем сообщение об отсутствии контента
        return redirect()->route('posts.show', $post)->with('success', 'Комментарий удалён!');

    }
}
