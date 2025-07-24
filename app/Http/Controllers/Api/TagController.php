<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TagController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly TagService $tagService,
        private readonly PostService $postService
    ) {
    }

    /**
     * Получить список тегов
     *
     * @response 200 [
     *   {"id": 1, "name": "PHP"}
     * ]
     */
    public function index(): AnonymousResourceCollection
    {
        $tags = $this->tagService->index();
        return TagResource::collection($tags);
    }

    /**
     * Создать тег
     *
     * @authenticated
     * @bodyParam name string required Название тега. Example: Laravel
     */
    public function store(StoreTagRequest $request): TagResource
    {
        // Проверяем является ли Юзер Админом
        $this->authorize('create', Tag::class);

        // Получаем экземпляр нового отвалидированного Тега
        $tag = $this->tagService->create($request->validated());

        // Возвращаем новый ресурс Тега
        return new TagResource($tag);
    }

    /**
     * Получить конкретную категорию
     *
     */
    public function show(Tag $tag): TagResource
    {
        return new TagResource($tag);
    }

    /**
     * Обновить тег
     *
     * @authenticated
     * @bodyParam name string required Название тега. Example: REST API
     * @urlParam tag_id int required ID тега. Example: 1
     */
    public function update(UpdateTagRequest $request, Tag $tag): TagResource
    {
        // Проверяем является ли Юзер Админом
        $this->authorize('update', $tag);

        // Обновляем текущий Тег валидированными данными
        $tag = $this->tagService->update($tag, $request->validated());

        // Возвращаем обновленный Тег в виде ресурса
        return new TagResource($tag);
    }

    /**
     * Удалить тег
     *
     * @authenticated
     * @urlParam tag_id int required ID тега. Example: 1
     */
    public function destroy(Tag $tag): JsonResponse
    {
        // Проверяем является ли Юзер Админом
        $this->authorize('delete', $tag);

        $this->tagService->delete($tag);

        return response()->json(['message' => 'Tag deleted']);
    }

    /**
     * Получить посты по тегу
     * @urlParam tag_id int required ID тега. Example: 1
     */
    public function posts(Tag $tag): AnonymousResourceCollection
    {
        $posts = $this->postService->getPostsByTag($tag);
        return PostResource::collection($posts);
    }
}
