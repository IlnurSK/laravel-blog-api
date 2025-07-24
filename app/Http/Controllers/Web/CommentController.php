<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CommentController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly CommentService $commentService,
    ) {}

    /**
     * Сохранить новый комментарий
     *
     * @param StoreCommentRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function store(StoreCommentRequest $request, Post $post): RedirectResponse
    {
        // Создаем коммент, авторизованным юзером
        $this->commentService->create(
            $request->validated(),
            $post,
            Auth::user()
        );

        // Возвращаем перенаправление на страницу с постом и с сообщением об успехе
        return redirect()->route('posts.show', $post)
            ->with('success', 'Новый комментарий добавлен!');
    }

    /**
     * Вернуть форму редактирования комментария
     *
     * @param Post $post
     * @param Comment $comment
     * @return View
     */
    public function showEdit(Post $post, Comment $comment): View
    {
        return view('comments.edit', compact('post', 'comment'));
    }

    /**
     * Обновить комментарий
     *
     * @param UpdateCommentRequest $request
     * @param Post $post
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment): RedirectResponse
    {
        // Проверяем является ли юзер владельцем
        $this->authorize('update', $comment);

        $this->commentService->update($comment, $request->validated());

        // Перенаправляем на страницу с постом и с сообщением об обновлении
        return redirect()->route('posts.show', $post)
            ->with('success', 'Комментарий обновлён!');
    }

    /**
     * Удалить комментарий
     *
     * @param Post $post
     * @param Comment $comment
     * @return RedirectResponse
     */
    public function destroy(Post $post, Comment $comment): RedirectResponse
    {
        // Проверяем является ли юзер владельцем коммента
        $this->authorize('delete', $comment);

        // Удаляем Коммент
        $this->commentService->delete($comment);

        // Возвращаем сообщение об отсутствии контента
        return redirect()->route('posts.show', $post)
            ->with('success', 'Комментарий удалён!');
    }
}
