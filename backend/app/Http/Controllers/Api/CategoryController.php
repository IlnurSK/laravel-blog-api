<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Получить все категории
     *
     * @response 200 [
     *   {"id": 1, "name": "Laravel"}
     * ]
     */
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Создать новую категорию
     *
     * @authenticated
     * @bodyParam name string required Название категории. Example: Laravel
     */
    public function store(StoreCategoryRequest $request)
    {
        // Проверяем является ли юзер админом
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Создаем экземпляр новой Категории
        $category = Category::create($request->validated());

        // Возвращаем ресурсный класс
        return new CategoryResource($category);
    }

    /**
     * Получить конкретную категорию
     *
     */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Обновить категорию
     *
     * @authenticated
     * @bodyParam name string required Название категории. Example: Обновленная
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Проверяем является ли Юзер админом
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Обновляем валидированные данные в текущей Категории
        $category->update($request->validated());

        // Возвращаем обновленную категорию в виде ресурса
        return new CategoryResource($category);
    }

    /**
     * Удалить категорию
     *
     * @authenticated
     * @urlParam category_id int required ID категории. Example: 1
     */
    public function destroy(Category $category)
    {
        // Проверяем является ли Юзер Админом
        if (!Auth::user()->is_admin) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Удаляем категорию
        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }

    /**
     * Получить посты по категории
     * @urlParam category_id int required ID категории. Example: 1
     */
    public function posts(Category $category)
    {
        $posts = $category->posts()->with(['user', 'tags'])->latest()->paginate(10);

        return PostResource::collection($posts);
    }
}
