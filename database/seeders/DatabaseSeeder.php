<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;

/**
 * Главный сидер базы данных.
 *
 * Создает пользователей, категории, теги, посты и комментарии
 * с использованием фабрик и связывает теги с постами.
 */

class DatabaseSeeder extends Seeder
{
    /**
     * Запустить наполнение базы тестовыми данными.
     *
     * Создает 1 админа, 10 пользователей, 5 категорий, 10 тегов, 30 постов (с тегами) и 60 комментариев.
     *
     * @return void
     */
    public function run(): void
    {
        // Создаем администратора 1 шт
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('12345'),
            'is_admin' => true,
        ]);

        // Создаем Пользователей 10 шт
        User::factory(10)->create();

        // Создаем Категорий 5 шт
        Category::factory(5)->create();

        // Создаем Тегов 10 шт
        Tag::factory(10)->create();

        // Создаем посты 30шт, к каждой прикрепляем рандомные Теги
        Post::factory(30)->create()->each(function ($post) {
            $tagIds = Tag::query()->inRandomOrder()->take(rand(1, 3))->pluck('id');
            $post->tags()->attach($tagIds);
        });

        // Создаем Комменты 60шт
        Comment::factory(60)->create();
    }
}
