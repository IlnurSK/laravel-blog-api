<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CategoryService
{
    public function index(): Collection
    {
        return Category::all();
    }
    public function create(array $data): Category
    {
        // Возвращаем экземпляр новой Категории
        return Category::create($data);
    }

    public function update(Category $category, array $data): Category
    {
        // Обновляем данные в текущей Категории
        $category->update($data);
        return $category;
    }

    public function delete(Category $category): void
    {
        // Удаляем категорию
        $category->delete();
    }

}
