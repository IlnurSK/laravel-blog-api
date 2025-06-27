<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CommentFeatureTest extends TestCase
{
    use RefreshDatabase;

    // Тест пользователь может удалить собственный коммент
    public function test_user_can_delete_own_comment()
    {
        // Создаем пользователя
        $user = User::factory()->create();

        // Создаем пост
        $post = Post::factory()->create();

        // Создаем коммент, связанный с нашим постом и юзером
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Создаем ответ, от лица юзера пробуем удалить данный коммент
        $response = $this->actingAs($user)->deleteJson("/api/comments/{$comment->id}");

        // Ожидаем ответ со статусом 200 и JSON с подтверждением
        $response->assertStatus(200)
            ->assertJson(['message' => 'Comment deleted']);

        // Проверям что в БД нет больше этого коммента
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }


    // Тест юзер не может удалить чужой коммент
    public function test_user_cannot_delete_foreign_comment()
    {
        // Создаем юзера
        $user = User::factory()->create();

        // Создаем другого юзера
        $otherUser = User::factory()->create();

        // Создаем пост созданный первым юзером
        $post = Post::factory()->create(['user_id' => $user->id]);

        // Создаем коммент к этому посту, связанный с другим юзером
        $comment = Comment::factory()->create([
            'user_id' => $otherUser->id,
            'post_id' => $post->id,
        ]);

        // Создаем ответ, от лица первого юзера пытаемся удалить коммент
        $response = $this->actingAs($user)
            ->deleteJson("/api/comments/{$comment->id}");

        // Ожидаем ответ со статусом 403
        $response->assertStatus(403);

        // Проверям что в БД данный коммент сохранился
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    // Тест гость не может удалить комментарий
    public function test_guest_cannot_delete_comment()
    {
        // Создаем комментарий
        $comment = Comment::factory()->create();

        // Пытаемся удалить этот комментарий, ожидаем статус 401
        $this->deleteJson("/api/comments/{$comment->id}")->assertStatus(401);
    }

}
