<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class HomeController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly PostService $postService,
        private readonly CategoryService $categoryService,
        private readonly TagService $tagService,
    ) {
    }

    /**
     * Вернуть представление главной страницы со списком постов
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // Получаем из запроса ID категории
        $categoryId = $request->integer('category_id') ?: null;

        // Получаем из запроса массив ID тегов
        $tagIds = $request->query('tag_ids', []);

        // Получаем Посты из сервиса отфильтрованного по нашей категории и тегам и публикации
        $posts = $this->postService->index($categoryId, $tagIds);

        // Получаем список категорий
        $categories = $this->categoryService->index();

        // Получаем список тегов
        $tags = $this->tagService->index();

        return view('home.index', compact('posts', 'categories', 'tags', 'categoryId', 'tagIds'));
    }
}
