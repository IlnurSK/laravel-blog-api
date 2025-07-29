<?php

namespace Tests\Feature;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Функциональные тесты модели комментариев.
 *
 * @covers \App\Models\Comment
 * @covers \App\Http\Controllers\Api\CommentController
 * @covers \App\Policies\CommentPolicy
 */

class CommentFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет, что пользователь может удалить собственный комментарий.
     *
     * @return void
     */
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
        $response = $this->actingAs($user)->deleteJson("/api/posts/{$post->id}/comments/{$comment->id}");

        // Ожидаем ответ со статусом 204 (noContent())
        $response->assertStatus(204);

        // Проверяем что в БД нет больше этого коммента
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
    }


    /**
     * Проверяет, что пользователь не может удалить чужой комментарий
     *
     * @return void
     */
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
            ->deleteJson("/api/posts/{$post->id}/comments/{$comment->id}");

        // Ожидаем ответ со статусом 403
        $response->assertStatus(403);

        // Проверяем что в БД данный коммент сохранился
        $this->assertDatabaseHas('comments', ['id' => $comment->id]);
    }

    /**
     * Проверяет, что гость не может удалить комментарий
     *
     * @return void
     */
    public function test_guest_cannot_delete_comment()
    {
        // Создаем пост
        $post = Post::factory()->create();

        // Создаем комментарий связанный с постом
        $comment = Comment::factory()->create(['user_id' => $post->user_id]);

        // Пытаемся удалить этот комментарий, ожидаем статус 401
        $this->deleteJson("/api/posts/{$post->id}/comments/{$comment->id}")->assertStatus(401);
    }
}
