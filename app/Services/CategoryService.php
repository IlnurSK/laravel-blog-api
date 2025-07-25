<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;

/**
 * Сервис для работы с категориями.
 */
class CategoryService
{
    /**
     * Получить список всех категорий.
     *
     * @return Collection<Category> Коллекция категорий
     */
    public function index(): Collection
    {
        return Category::all();
    }

    /**
     * Создать новую категорию.
     *
     * @param array{name: string} $data Данные для создания
     * @return Category Новая категория
     *
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Обновить категорию.
     *
     * @param Category $category Категория для обновления
     * @param array{name: string} $data Новые данные
     * @return Category Обновленная категория
     */
    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category;
    }

    /**
     * Удалить категорию.
     *
     * @param Category $category Категория для удаления
     * @return void
     */
    public function delete(Category $category): void
    {
        $category->delete();
    }
}
