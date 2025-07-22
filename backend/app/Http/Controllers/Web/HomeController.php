<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Инициализируем все наши сервисы в конструкторе
    public function __construct(
        private readonly PostService $postService,
        private readonly CategoryService $categoryService,
        private readonly TagService $tagService,
    ) {
    }

    // Метод отображения главной страницы, с получением данных через сервисы
    public function index(Request $request)
    {
        // Получаем из запроса ID категории
        $categoryId = $request->query('category_id');

        // Получаем из запроса массив ID тегов
        $tagIds = $request->query('tag_ids', []);

        // Получаем Посты из сервиса отфильтрованного по нашей категории и тегам и публикации
        $posts = $this->postService->index($categoryId, $tagIds);

        // Получаем список категорий
        $categories = $this->categoryService->index();

        // Получаем список тегов
        $tags = $this->tagService->index();

        // Возвращаем представление, передавая туда все наши данные
        return view('home.index', compact('posts', 'categories', 'tags', 'categoryId', 'tagIds'));
    }
}
