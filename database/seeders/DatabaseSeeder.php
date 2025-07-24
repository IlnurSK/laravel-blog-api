<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // Создаем Пользователей 10 шт
        User::factory(10)->create();

        // Создаем Категорий 5 шт
        Category::factory(5)->create();

        // Создаем Тегов 10 шт
        Tag::factory(10)->create();

        // Создаем посты 30шт, к каждой прикрепляем рандомные Теги
        Post::factory(30)->create()->each(function ($post) {
            $tagIds = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $post->tags()->attach($tagIds);
        });

        // Создаем Комменты 60шт
        Comment::factory(60)->create();
    }
}
