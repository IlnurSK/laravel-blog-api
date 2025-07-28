<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Фабрика для категорий.
 *
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Определить значения по умолчанию для категории
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
