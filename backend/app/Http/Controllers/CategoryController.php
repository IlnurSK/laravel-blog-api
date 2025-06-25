<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Метод получения всех Категорий
    public function index()
    {
        return Category::all();
    }

    /**
     * Store a newly created resource in storage.
     */

    // Метод сохранения новой Категории
    public function store(StoreCategoryRequest $request)
    {
        // Создаем экземпляр новой Категории
        $category = Category::create($request->validated());

        // Возвращаем экземпляр в JSON со статусом 201
        return response()->json($category, 201);
    }

    /**
     * Display the specified resource.
     */

    // Метод получения конкретной категории
    public function show(Category $category)
    {
        return $category;
    }

    /**
     * Update the specified resource in storage.
     */

    // Метод получения обновленной Категории
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Обновляем валидированные данные в текущей Категории
        $category->update($request->validated());

        // Возвращаем обновленный экземпляр в JSON
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     */

    // Метод удаления Категории, возвращает сообщение об успехе
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(['message' => 'Category deleted']);
    }
}
