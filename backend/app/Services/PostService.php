<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Pagination\LengthAwarePaginator;
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

    public function getPostsByCategory(Category $category): LengthAwarePaginator
    {
        return $category->posts()
            ->with(['user', 'category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getPostsByTag(Tag $tag): LengthAwarePaginator
    {
        return $tag->posts()
            ->with(['user', 'category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    // Метод фильтрации постов по Категории и Тегам
    public function getFilteredPosts($categoryId = null, array $tagIds = []): LengthAwarePaginator
    {
        // Создаем запрос к Постам, со связанными пользователями, категориями и тегами
        $query = Post::with(['user', 'category', 'tags']);

        // Если есть ID категории, то добавляем в запрос категорию
        if ($categoryId) {
            $query->where('posts.category_id', $categoryId);
        }

        // Если массив Тегов не пустой, то добавляем в запрос теги
        if (!empty($tagIds)) {
            foreach ($tagIds as $tagId) {
                $query->whereHas('tags', function ($q) use ($tagId) {
                    $q->where('tags.id', $tagId);
                });
            }
        }

        // Возвращаем запрос с фильтром по свежести и пагинацией на 10
        return $query->latest()->paginate(10);
    }

}
