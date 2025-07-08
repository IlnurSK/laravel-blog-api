<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Инстанцируем PostService
    public function __construct(private PostService $postService)
    {
    }

    /**
     * Получить все посты
     *
     * @queryParam category_id int ID категории. Example: 1
     * @queryParam tag_ids integer[] Массив ID тегов. Example: [1, 2]
     */
    public function index(Request $request)
    {
        // Получаем все Посты со связанными данными
        $query = Post::with(['user', 'category', 'tags']);

        // Если указаны Категории, фильтруем Посты
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Если указаны Теги, фильтруем Посты
        if ($request->has('tag_ids')) {
            $tagIds = $request->input('tag_ids');
            if (is_string($tagIds)) {
                $tagIds = explode(',', $tagIds); // поддержка строки "1,2"
            }
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', (array) $tagIds);
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

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
    public function store(StorePostRequest $request)
    {
        // Проверям права пользователя на создание Поста
        $this->authorize('create', Post::class);

        // Получаем новый Пост с валидированной информацией
        $post = $this->postService->create($request->validated());

        // Возвращаем новый Пост в виде ресурса
        return new PostResource($post);
    }

    /**
     * Получить пост по ID
     * @urlParam post_id int required ID поста. Example: 1
     */
    public function show(Post $post)
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
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Проверям права пользователя на создание Поста
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
    public function destroy(Post $post)
    {
        // Проверям права пользователя на удаление Поста
        $this->authorize('delete', $post);

        // Удаляем пост
        $this->postService->delete($post);

        // Возвращаем сообщение об успехе
        return response()->json(['message' => 'Post deleted']);
    }
}
