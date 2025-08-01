<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{
    // Инициализируем сервисы
    public function __construct(private readonly PostService $postService)
    {
    }

    /**
     * Получить все посты
     *
     * @queryParam category_id int ID категории. Example: 1
     * @queryParam tag_ids integer[] Массив ID тегов. Example: [1, 2]
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $categoryId = $request->integer('category_id') ?: null;
        $tagIds = $request->input('tag_ids', []);

        if (is_string($tagIds)) {
            $tagIds = explode(',', $tagIds);
        }

        $posts = $this->postService->index($categoryId, $tagIds);

        return PostResource::collection($posts);
    }

    /**
     * Создать новый пост
     *
     * @authenticated
     * @bodyParam title string required Заголовок поста. Example: Laravel REST API
     * @bodyParam body string required Текст поста. Example: Содержание статьи
     * @bodyParam category_id int ID категории (опционально). Example: 1
     * @bodyParam tag_ids array Массив ID тегов (опционально). Example: [1, 2]
     * @bodyParam is_published bool Опубликовано (по умолчанию false). Example: false
     */
    public function store(StorePostRequest $request): PostResource
    {
        // Проверяем права пользователя на создание Поста
        $this->authorize('create', Post::class);

        // Получаем новый Пост с валидированной информацией
        $post = $this->postService->create($request->user(), $request->validated());

        // Возвращаем новый Пост в виде ресурса
        return new PostResource($post);
    }

    /**
     * Получить пост по ID
     * @urlParam post_id int required ID поста. Example: 1
     */
    public function show(Post $post): PostResource
    {
        // Возвращаем конкретный Пост со связанными данными
        $post->load(['user', 'category', 'tags', 'comments']);
        return new PostResource($post);
    }

    /**
     * Обновить пост
     *
     * @authenticated
     * @bodyParam title string Заголовок. Example: Новый заголовок
     * @bodyParam body string Контент. Example: Обновленное содержание
     * @bodyParam category_id int ID категории (опционально). Example: 2
     * @bodyParam tag_ids array Массив ID тегов (опционально). Example: [2, 3]
     * @bodyParam is_published boolean Опубликовано (по умолчанию false). Example: false
     * @urlParam post_id int required ID поста. Example: 1
     */
    public function update(UpdatePostRequest $request, Post $post): PostResource
    {
        // Проверяем права пользователя на создание Поста
        $this->authorize('update', $post);

        // Обновляем Пост
        $post = $this->postService->update($post, $request->validated());

        // Возвращаем обновленный Пост в виде ресурса
        return new PostResource($post);
    }

    /**
     * Удалить пост
     *
     * @authenticated
     * @urlParam post_id int required ID поста. Example: 1
     */
    public function destroy(Post $post): JsonResponse
    {
        // Проверяем права пользователя на удаление Поста
        $this->authorize('delete', $post);

        // Удаляем пост
        $this->postService->delete($post);

        // Возвращаем сообщение об успехе
        return response()->json(['message' => 'Post deleted']);
    }
}
