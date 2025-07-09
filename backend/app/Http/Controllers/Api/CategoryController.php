<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    // Инстанцируем CategoryService
    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly PostService $postService
    ) {
    }

    /**
     * Получить все категории
     *
     * @response 200 [
     *   {"id": 1, "name": "Laravel"}
     * ]
     */
    public function index(): AnonymousResourceCollection
    {
        $categories = $this->categoryService->index();
        return CategoryResource::collection($categories);
    }

    /**
     * Создать новую категорию
     *
     * @authenticated
     * @bodyParam name string required Название категории. Example: Laravel
     */
    public function store(StoreCategoryRequest $request): CategoryResource
    {
        // Проверяем является ли юзер админом
        $this->authorize('create', Category::class);

        // Создаем новую категорию
        $category = $this->categoryService->create($request->validated());

        // Возвращаем новый ресурсный класс
        return new CategoryResource($category);
    }

    /**
     * Получить конкретную категорию
     *
     */
    public function show(Category $category): CategoryResource
    {
        return new CategoryResource($category);
    }

    /**
     * Обновить категорию
     *
     * @authenticated
     * @bodyParam name string required Название категории. Example: Обновленная
     */
    public function update(UpdateCategoryRequest $request, Category $category): CategoryResource
    {
        // Проверяем является ли Юзер админом
        $this->authorize('update', $category);

        // Обновляем валидированные данные в текущей Категории
        $category = $this->categoryService->update($category, $request->validated());

        // Возвращаем обновленную категорию в виде ресурса
        return new CategoryResource($category);
    }

    /**
     * Удалить категорию
     *
     * @authenticated
     * @urlParam category_id int required ID категории. Example: 1
     */
    public function destroy(Category $category): JsonResponse
    {
        // Проверяем является ли Юзер Админом
        $this->authorize('delete', $category);

        // Удаляем категорию
        $this->categoryService->delete($category);

        return response()->json(['message' => 'Category deleted']);
    }

    /**
     * Получить посты по категории
     * @urlParam category_id int required ID категории. Example: 1
     */
    public function posts(Category $category): AnonymousResourceCollection
    {
        $posts = $this->postService->getPostsByCategory($category);
        return PostResource::collection($posts);
    }
}
