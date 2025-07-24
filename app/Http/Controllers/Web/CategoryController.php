<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    // Инициализируем сервис
    public function __construct(
        private readonly CategoryService $categoryService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все категории
        $categories = $this->categoryService->index();

        // Возвращаем вид, передав туда данные
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Возвращаем вид создания категорий
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        // Используя сервис создаем новую категорию
        $this->categoryService->create($request->validated());

        // Перенаправляем на страницу категорий с уведомлением
        return redirect()->route('admin.categories.index')->with('success', 'Категория добавлена');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Возвращаем представление редактирования категорий, передавая туда категорию
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        // Используя сервис обновляем категорию, передав туда новые данные
        $this->categoryService->update($category, $request->validated());

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Используя сервис удаляем категорию
        $this->categoryService->delete($category);

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена');
    }
}
