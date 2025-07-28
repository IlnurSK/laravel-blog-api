<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для постов.
 *
 * @extends Factory<Post>
 */
class PostFactory extends Factory
{
    /**
     * Определить значения по умолчанию для поста
     *
     * @return array{
     *     user_id: int|Factory,
     *     category_id: int|Factory,
     *     title: string,
     *     body: string,
     *     is_published: bool
     * }
     */
    public function definition(): array
    {
        return [
            'user_id'      => User::query()->inRandomOrder()->value('id') ?? User::factory(),
            'category_id'  => Category::query()->inRandomOrder()->value('id') ?? Category::factory(),
            'title'        => $this->faker->sentence(),
            'body'         => $this->faker->paragraph(6),
            'is_published' => $this->faker->boolean(80),
        ];
    }
}
