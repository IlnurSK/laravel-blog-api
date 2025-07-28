<?php

namespace Database\Factories;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика тегов.
 *
 * @extends Factory<Tag>
 */
class TagFactory extends Factory
{
    /**
     * Определить значения по умолчанию для тега
     *
     * @return array{name: string}
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
        ];
    }
}
