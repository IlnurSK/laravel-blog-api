<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Функциональные тесты модели постов.
 *
 * @covers \App\Models\Post
 * @covers \App\Http\Controllers\Api\PostController
 * @covers \App\Policies\PostPolicy
 */
class PostFeatureTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Проверяет, что авторизованный пользователь может создать пост.
     *
     * @return void
     */
    public function test_authenticated_user_can_create_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $tags = Tag::factory(3)->create();

        $payload = [
            'title' => 'Тестовый пост',
            'body' => 'Контент тестового поста',
            'category_id' => $category->id,
            'tag_ids' => $tags->pluck('id')->toArray(),
            'is_published' => true,
        ];

        $response = $this->actingAs($user)->postJson('/api/posts', $payload);

        $response->assertStatus(201)
            ->assertJsonFragment(['title' => 'Тестовый пост']);

        $this->assertDatabaseHas('posts', ['title' => 'Тестовый пост']);
    }

    /**
     * Проверяет, что неавторизованный пользователь (гость) не может создать пост.
     *
     * @return void
     */
    public function test_guest_cannot_create_post()
    {
        $this->postJson('/api/posts', [])->assertStatus(401);
    }

    /**
     * Проверяет, что авторизованный пользователь может обновить свой пост.
     *
     * @return void
     */
    public function test_authenticated_user_can_update_post()
    {
        $user = User::factory()->create();
        $category = Category::factory()->create();
        $tags = Tag::factory(2)->create();

        $post = Post::factory()->create([
            'user_id' => $user->id,
            'category_id' => $category->id,
        ]);

        $payload = [
            'title' => 'Обновленный заголовок',
            'body' => 'Новый контент поста',
            'category_id' => $category->id,
            'tag_ids' => $tags->pluck('id')->toArray(),
            'is_published' => false
        ];

        $response = $this->actingAs($user)->putJson("/api/posts/{$post->id}", $payload);

        $response->assertStatus(200)
            ->assertJsonFragment(['title' => 'Обновленный заголовок']);

        $this->assertDatabaseHas('posts', ['id' => $post->id, 'title' => 'Обновленный заголовок']);
    }

    /**
     * Проверяет, что пользователь не может обновить чужой пост.
     *
     * @return void
     */
    public function test_user_cannot_update_others_post()
    {
        $author = User::factory()->create();
        $otherUser = User::factory()->create();

        $post = Post::factory()->create([
            'user_id' => $author->id,
        ]);

        $payload = [
            'title' => 'Попытка взлома',
        ];

        $this->actingAs($otherUser)
            ->putJson("/api/posts/{$post->id}", $payload)
            ->assertStatus(403);

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'title' => $post->title,
        ]);
    }
}
