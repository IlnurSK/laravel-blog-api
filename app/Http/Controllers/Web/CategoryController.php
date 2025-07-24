<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly CategoryService $categoryService,
    )
    {
    }

    /**
     * Вернуть представление со списком категорий
     *
     * @return View
     */
    public function index(): View
    {
        // Получаем все категории
        $categories = $this->categoryService->index();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Вернуть представление создания новой категорий
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Сохранить новую категорию
     *
     * @param StoreCategoryRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        // Используя сервис создаем новую категорию
        $this->categoryService->create($request->validated());

        // Перенаправляем на страницу категорий с уведомлением
        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория добавлена');
    }

    /**
     * Вернуть представление редактирования категории
     *
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Обновить категорию
     *
     * @param UpdateCategoryRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        // Используя сервис обновляем категорию, передав туда новые данные
        $this->categoryService->update($category, $request->validated());

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория обновлена');
    }

    /**
     * Удалить категорию
     *
     * @param Category $category
     * @return RedirectResponse
     */
    public function destroy(Category $category): RedirectResponse
    {
        // Используя сервис удаляем категорию
        $this->categoryService->delete($category);

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.categories.index')
            ->with('success', 'Категория удалена');
    }
}
