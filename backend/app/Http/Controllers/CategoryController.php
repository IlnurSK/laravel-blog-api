<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\PostResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Метод получения всех Категорий
    public function index()
    {
        return CategoryResource::collection(Category::all());
    }

    /**
     * Store a newly created resource in storage.
     */

    // Метод сохранения новой Категории
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
     * Display the specified resource.
     */

    // Метод получения конкретной категории
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    /**
     * Update the specified resource in storage.
     */

    // Метод получения обновленной Категории
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
     * Remove the specified resource from storage.
     */

    // Метод удаления Категории, возвращает сообщение об успехе
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

    // Метод вывода всех Постов связанных с Категорией
    public function posts(Category $category)
    {
        $posts = $category->posts()->with(['user', 'tags'])->latest()->paginate(10);

        return PostResource::collection($posts);
    }
}
