<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Получить список тегов
     *
     * @response 200 [
     *   {"id": 1, "name": "PHP"}
     * ]
     */
    public function index()
    {
        return TagResource::collection(Tag::all());
    }

    /**
     * Создать тег
     *
     * @authenticated
     * @bodyParam name string required Название тега. Example: Laravel
     */
    public function store(StoreTagRequest $request)
    {
        // Проверяем является ли Юзер Админом
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Получаем экземпляр нового отвалидированного Тега
        $tag = Tag::create($request->validated());

        // Возвращаем новый ресурс Тега
        return new TagResource($tag);
    }

    /**
     * Получить конкретную категорию
     *
     */
    public function show(Tag $tag)
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
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        // Проверяем является ли Юзер Админом
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Обновляем текущий Тег валидированными данными
        $tag->update($request->validated());

        // Возвращаем обновленный Тег в виде ресурса
        return new TagResource($tag);
    }

    /**
     * Удалить тег
     *
     * @authenticated
     * @urlParam tag_id int required ID тега. Example: 1
     */
    public function destroy(Tag $tag)
    {
        // Проверяем является ли Юзер Админом
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $tag->delete();

        return response()->json(['message' => 'Tag deleted']);
    }

    /**
     * Получить посты по тегу
     * @urlParam tag_id int required ID тега. Example: 1
     */
    public function posts(Tag $tag)
    {
        $posts = $tag->posts()->with(['user', 'category'])->latest()->paginate(10);

        return PostResource::collection($posts);
    }
}
