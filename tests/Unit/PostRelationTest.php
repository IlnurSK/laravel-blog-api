<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Модульные тесты отношений модели постов.
 *
 * @covers \App\Models\Post
 * @covers \App\Models\Tag
 * @covers \App\Models\Category
 * @covers \App\Models\User
 */
class PostRelationTest extends TestCase
{
    // Используем автообновление ДБ
    use RefreshDatabase;

    /**
     * Проверяет, что пост принадлежит пользователю.
     *
     * @return void
     */
    public function test_post_belongs_to_user()
    {
        // Создаем пост, связываем его с новым пользователем через for()
        $post = Post::factory()->for(User::factory())->create();

        // Ожидаем связь пользователя с постом, через InstanceOf
        $this->assertInstanceOf(User::class, $post->user);
    }


    /**
     * Проверяет, что пост принадлежит категории.
     *
     * @return void
     */
    public function test_post_belongs_to_category()
    {
        // Создаем пост, связываем его с новой категорией
        $post = Post::factory()->for(Category::factory())->create();

        // Ожидаем связь категории с постом
        $this->assertInstanceOf(Category::class, $post->category);
    }


    /**
     * Проверяет, что пост имеет теги.
     *
     * @return void
     */
    public function test_post_has_tags()
    {
        // Создаем пост
        $post = Post::factory()->create();

        // Создаем 3 тега
        $tags = Tag::factory(3)->create();

        // Добавляем к посту эти теги через attach
        $post->tags()->attach($tags);

        // Ожидаем количество привязанных тегов к посту равно 3
        $this->assertCount(3, $post->tags);

        // Ожидаем связь тегов с тегами поста
        $this->assertInstanceOf(Tag::class, $post->tags->first());
    }
}
