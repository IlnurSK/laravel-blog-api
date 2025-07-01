<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Http\Resources\PostResource;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Метод получения всех Тегов
    public function index()
    {
        return TagResource::collection(Tag::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    // Метод получения нового Тега
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
     * Display the specified resource.
     */

    // Метод получения конкретного Тега
    public function show(Tag $tag)
    {
        return new TagResource($tag);
    }

    /**
     * Update the specified resource in storage.
     */
    // Метод обновления Тега
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
     * Remove the specified resource from storage.
     */
    // Метод удаления текущего Тега
    public function destroy(Tag $tag)
    {
        // Проверяем является ли Юзер Админом
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $tag->delete();

        return response()->json(['message' => 'Tag deleted']);
    }

    // Метод получения всех Постов по Тегу
    public function posts(Tag $tag)
    {
        $posts = $tag->posts()->with(['user', 'category'])->latest()->paginate(10);

        return PostResource::collection($posts);
    }
}
