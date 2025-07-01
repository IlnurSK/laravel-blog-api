<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Метод получения всех Постов
    public function index(Request $request)
    {
        // Получаем все Посты со связанными данными
        $query = Post::with(['user', 'category', 'tags']);

        // Если указаны Категории, фильтруем Посты
        if ($request->has('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // Если указаны Теги, фильтруем Посты
        if ($request->has('tag_id')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('tags.id', $request->input('tag_id'));
            });
        }

        $posts = $query->orderBy('created_at', 'desc')->paginate(10);

        return PostResource::collection($posts);
    }

    /**
     * Store a newly created resource in storage.
     */

    // Метод сохранения нового Поста
    public function store(StorePostRequest $request)
    {
        // Получаем валидированную информацию
        $data = $request->validated();

        // Создаем пост с авторизованны юзером
        $post = Auth::user()->posts()->create($data);

        // Если в запросе есть Теги, привязываем их к Посту
        if (isset($data['tag_ids'])) {
            $post->tags()->attach($data['tag_ids']);
        }
        // Предзагружаем связанные данные
        $post->load(['user', 'category', 'tags']);

        // Возвращаем новый Пост в виде ресурса
        return new PostResource($post);
    }

    /**
     * Display the specified resource.
     */

    // Метод получения конкретного Поста
    public function show(Post $post)
    {
        // Возвращаем конкретный Пост со связанными данными
        $post->load(['user', 'category', 'tags', 'comments']);
        return new PostResource($post);
    }

    /**
     * Update the specified resource in storage.
     */

    // Метод обновления Поста
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Обновляем Пост
        $data = $request->validated();
        $post->update($data);

        // Если в запросе есть Теги, привязываем их к Посту
        if (isset($data['tag_ids'])) {
            $post->tags()->sync($data['tag_ids']);
        }

        // Предзагружаем обновленный Пост с тегами
        $post->load(['user', 'category', 'tags']);

        // Возвращаем обновленный Пост в виде ресурса
        return new PostResource($post);
    }

    /**
     * Remove the specified resource from storage.
     */

    // Метод удаления Поста
    public function destroy(Post $post)
    {
        // Удаляем связанные теги и удаляем Пост
        $post->tags()->detach();
        $post->delete();

        // Возвращаем сообщение об успехе
        return response()->json(['message' => 'Post deleted']);
    }
}
