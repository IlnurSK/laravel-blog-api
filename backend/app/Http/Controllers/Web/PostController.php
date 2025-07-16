<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // Инициализируем необходимые сервисы
    public function __construct(
        private readonly PostService $postService,
        private readonly CategoryService $categoryService,
        private readonly TagService $tagService,
    )
    {
    }

    // Метод отображения представления Поста
    public function show(Post $post)
    {
        $post->load(['user', 'category', 'tags', 'comments.user']);

        return view('posts.show', compact('post'));
    }

    // Метод отображения представления создания Поста
    public function create()
    {
        // Получаем все категории
        $categories = $this->categoryService->index();

        // Получаем все теги
        $tags = $this->tagService->index();

        // Возвращаем представление и передаем туда данные
        return view('posts.create', compact('categories', 'tags'));
    }


    // Метод сохранения нового поста через сервис
    public function store(StorePostRequest $request)
    {
        // Сохраняем валидированные данные
        $this->postService->create($request->user(), $request->validated());

        // Возвращаем перенаправление на страницу постов с сообщением о успехе
        return redirect()->route('posts.mine')->with('success', 'Пост создан');
    }


    // Метод отображения представления с постами юзера
    public function mine()
    {
        // Получаем все посты авторизованного пользователя, с сортировкой по дате и пагинацией
        $posts = Auth::user()->posts()->latest()->paginate(5);

        // Возвращаем представление и передаем туда данные
        return view('posts.mine', compact('posts'));
    }

}
