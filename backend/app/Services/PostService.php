<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Auth;

class PostService
{
    public function create(array $data): Post
    {
        // Создаем пост с авторизованны юзером
        $post = Auth::user()->posts()->create($data);

        // Если в запросе есть Теги, привязываем их к Посту
        if (isset($data['tag_ids'])) {
            $post->tags()->attach($data['tag_ids']);
        }
        // Возвращаем Пост и предзагружаем связанные данные
        return $post->load(['user', 'category', 'tags']);
    }

    public function update(Post $post, array $data): Post
    {
        // Обновляем пост
        $post->update($data);

        // Если в запросе есть Теги, привязываем их к Посту
        if (isset($data['tag_ids'])) {
            $post->tags()->sync($data['tag_ids']);
        }

        // Возвращаем обновленный Пост и предзагружаем связанные данные
        return $post->load(['user', 'category', 'tags']);
    }

    public function delete(Post $post): void
    {
        // Удаляем связанные теги и удаляем Пост
        $post->tags()->detach();
        $post->delete();
    }

    public function getPostsByCategory(Category $category): AnonymousResourceCollection
    {
        $posts = $category->posts()
            ->with(['user', 'category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return PostResource::collection($posts);
    }

}
