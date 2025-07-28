<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для комментариев.
 *
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Определить значения по умолчанию для комментария
     *
     * @return array{user_id: int|Factory, post_id: int|Factory, body: string}
     */
    public function definition(): array
    {
        return [
            // user_id рандом если нет создаем
            'user_id' => User::query()->inRandomOrder()->value('id') ?? User::factory(),

            // post_id рандом если нет создаем
            'post_id' => Post::query()->inRandomOrder()->value('id') ?? Post::factory(),

            // body фейкер предложение из 12 слов
            'body'    => $this->faker->sentence(12),
        ];
    }
}
