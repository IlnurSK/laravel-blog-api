<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Сервис для работы с постами.
 */
class PostService
{
    /**
     * Получить все опубликованные посты с возможной фильтрацией.
     *
     * @param int|null $categoryId ID категории (опционально)
     * @param array $tagIds Массив ID тегов для фильтрации (опционально)
     * @return LengthAwarePaginator Пагинированная коллекция постов
     */
    public function index(?int $categoryId = null, array $tagIds = []): LengthAwarePaginator
    {
        // Получаем все Посты со связанными данными
        $query = Post::with(['user', 'category', 'tags'])->where('posts.is_published', true);

        // Если указаны Категории, фильтруем Посты
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Если указаны Теги, фильтруем Посты
        if (!empty($tagIds)) {
            $query->whereHas('tags', function ($q) use ($tagIds) {
                $q->whereIn('tags.id', $tagIds);
            });
        }

        return $query->orderBy('created_at', 'desc')->paginate(10);
    }

    /**
     * Создать новый пост.
     *
     * @param User $user Автор поста
     * @param array $data Данные для создания поста
     * @return Post Новый пост
     */
    public function create(User $user, array $data): Post
    {
        // Создаем пост с авторизованны юзером
        $post = $user->posts()->create($data);

        // Если в запросе есть Теги, привязываем их к Посту
        if (isset($data['tag_ids'])) {
            $post->tags()->attach($data['tag_ids']);
        }
        // Возвращаем Пост и предзагружаем связанные данные
        return $post->load(['user', 'category', 'tags']);
    }

    /**
     * Обновить пост.
     *
     * @param Post $post Пост для обновления
     * @param array $data Данные для обновления
     * @return Post Обновленный пост
     */
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

    /**
     * Удалить пост.
     *
     * @param Post $post Пост для удаления
     * @return void
     */
    public function delete(Post $post): void
    {
        // Удаляем связанные теги и удаляем Пост
        $post->tags()->detach();
        $post->delete();
    }

    /**
     * Получить посты по категории.
     *
     * @param Category $category Категория, по которой фильтруются посты
     * @return LengthAwarePaginator Пагинированная коллекция постов
     */
    public function getPostsByCategory(Category $category): LengthAwarePaginator
    {
        return $category->posts()
            ->with(['user', 'category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    /**
     * Получить посты по тегу.
     *
     * @param Tag $tag Тег, по которой фильтруются посты
     * @return LengthAwarePaginator Пагинированная коллекция постов
     */
    public function getPostsByTag(Tag $tag): LengthAwarePaginator
    {
        return $tag->posts()
            ->with(['user', 'category', 'tags'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }
}
