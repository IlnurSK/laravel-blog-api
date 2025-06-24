<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Метод получения всех Постов
    public function index()
    {
        // Возвращаем все Посты со связанными данными, в виде постраничного списка
        return Post::with(['user', 'category', 'tags'])->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */

    // Метод сохранения нового Поста
    public function store(StorePostRequest $request)
    {
        // Создание нового поста (валидированного) от имени текущего аутентифицированного пользователя
        $post = $request->user()->posts()->create($request->validated());

        // Если в запросе есть Теги, привязываем их к Посту
        if ($request->has('tag_ids')) {
            $post->tags()->sync($request->tag_ids);
        }

        // Возвращаем новый Пост с тегами и статусом 201 Created
        return response()->json($post->load('tags'), 201);
    }

    /**
     * Display the specified resource.
     */

    // Метод получения конкретного Поста
    public function show(Post $post)
    {
        // Возвращаем конкретный Пост со связанными данными
        return $post->load(['user', 'category', 'tags', 'comments']);
    }

    /**
     * Update the specified resource in storage.
     */

    // Метод обновления Поста
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Проверяем что Пост принадлежит текущему пользователю
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Обновляем Пост
        $post->update($request->validated());

        // Если в запросе есть Теги, привязываем их к Посту
        if ($request->has('tag_ids')) {
            $post->tags()->sync($request->tag_ids);
        }

        // Возвращаем обновленный Пост с тегами
        return response()->json($post->load('tags'));
    }

    /**
     * Remove the specified resource from storage.
     */

    // Метод удаления Поста
    public function destroy(Request $request, Post $post)
    {
        // Проверяем что Пост принадлежит текущему пользователю
        if ($request->user()->id !== $post->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Удаляем Пост
        $post->delete();

        // Возвращаем сообщение об успехе
        return response()->json(['message' => 'Post deleted.']);
    }
}
