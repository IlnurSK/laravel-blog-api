<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use App\Services\CommentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    // Инициализируем сервисы
    public function __construct(private readonly CommentService $commentService)
    {
    }

    /**
     * Получить комментарии к посту
     * @urlParam post_id int required ID поста. Example: 1
     */
    public function index(Post $post): AnonymousResourceCollection
    {
        // Возвращаем все Комменты со связанными данными, в виде постраничного списка
        $comments = $post->comments()->with(['user'])->latest()->paginate(10);

        return CommentResource::collection($comments);
    }

    /**
     * Добавить комментарий
     *
     * @authenticated
     * @bodyParam body string required Текст комментария. Example: Отличная статья!
     * @urlParam post_id int required ID поста. Example: 1
     */
    public function store(StoreCommentRequest $request, Post $post): CommentResource
    {
        // Создаем коммент
        $comment = $this->commentService->create(
            $request->validated(),
            $post,
            Auth::user()
        );

        // Возвращаем новый Коммент в виде ресурса, загружая связанные данные
        return new CommentResource($comment->load(['user', 'post']));
    }

    /**
     * Получить один комментарий
     * @urlParam post_id int required ID поста. Example: 1
     * @urlParam comment_id int ID комментария. Example: 1
     */
    public function show(Post $post, Comment $comment): JsonResponse|CommentResource
    {
        // Проверяем существование коммента
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment not found in this post'], 404);
        }
        // Возвращаем конкретный Коммент со связанными данными
        $comment->load(['user']);
        return new CommentResource($comment);
    }

    /**
     * Обновить комментарий
     *
     * @authenticated
     * @bodyParam body string required Текст комментария. Example: Обновленный текст
     * @urlParam post_id int required ID поста. Example: 1
     * @urlParam comment_id int ID комментария. Example: 1
 */
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment): CommentResource|JsonResponse
    {
        // Проверяем существование коммента
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Комментарий не обнаружен'], 404);
        }

        // Проверяем есть ли права у юзера на обновление коммента
        $this->authorize('update', $comment);

        $comment = $this->commentService->update($comment, $request->validated());

        // Возвращаем обновленный Комментарий в виде ресурса
        return new CommentResource($comment);
    }

    /**
     * Удалить комментарий
     *
     * @authenticated
     * @urlParam post_id int required ID поста. Example: 1
     * @urlParam comment_id int ID комментария. Example: 1
 */
    public function destroy(Post $post, Comment $comment): JsonResponse|Response
    {
        // Проверяем существование коммента
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Комментарий не обнаружен'], 404);
        }

        // Проверяем права на удаление у пользователя
        $this->authorize('delete', $comment);

        // Удаляем Коммент
        $this->commentService->delete($comment);

        // Возвращаем сообщение об отсутствии контента
        return response()->noContent();
    }
}
