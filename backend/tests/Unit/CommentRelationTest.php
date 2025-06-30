<?php

namespace Tests\Unit;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentRelationTest extends TestCase
{
    // Используем обновление БД
    use RefreshDatabase;

    // Тест Коммент принадлежит пользователю
    public function test_comment_belongs_to_user()
    {
        // Создаем Коммент, связываем его с новым юзером
        $comment = Comment::factory()->for(User::factory())->create();

        // Проверяем что Юзер из Коммента принадлежит к классу Юзеров
        $this->assertInstanceOf(User::class, $comment->user);
    }


    // Тест коммент принадлежит к посту
    public function test_comment_belongs_to_post()
    {
        // Создаем Коммент, связываем его с новым постом
        $comment = Comment::factory()->for(Post::factory())->create();

        // Проверяем что Пост из Коммента принадлежит к классу Постов
        $this->assertInstanceOf(Post::class, $comment->post);
    }
}
