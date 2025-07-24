<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Post;
use App\Services\CategoryService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PostController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly PostService $postService,
        private readonly CategoryService $categoryService,
        private readonly TagService $tagService,
    ) {
    }

    /**
     * Вернуть представление поста
     *
     * @param Post $post
     * @return View
     */
    public function show(Post $post): View
    {
        $post->load(['user', 'category', 'tags', 'comments.user']);

        return view('posts.show', compact('post'));
    }

    /**
     * Вернуть представление создания нового поста
     *
     * @return View
     */
    public function create(): View
    {
        // Получаем все категории
        $categories = $this->categoryService->index();

        // Получаем все теги
        $tags = $this->tagService->index();

        return view('posts.create', compact('categories', 'tags'));
    }


    /**
     * Сохранить новый пост
     *
     * @param StorePostRequest $request
     * @return RedirectResponse
     */
    public function store(StorePostRequest $request): RedirectResponse
    {
        // Сохраняем валидированные данные
        $this->postService->create($request->user(), $request->validated());

        // Возвращаем перенаправление на страницу постов с сообщением об успехе
        return redirect()->route('posts.mine')
            ->with('success', 'Пост создан');
    }

    /**
     * Удалить пост
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function destroy(Post $post): RedirectResponse
    {
        // Проверка прав на удаление (только свой пост)
        $this->authorize('delete', $post);

        // Удаляем через сервис пост
        $this->postService->delete($post);

        // Перенаправляем на страницу постов с успехом
        return redirect()->route('posts.mine')
            ->with('success', 'Пост удалён');
    }


    /**
     * Вернуть представление со списком постов пользователя
     *
     * @return View
     */
    public function mine(): View
    {
        // Получаем все посты авторизованного пользователя, с сортировкой по дате и пагинацией
        $posts = Auth::user()->posts()->with(['category', 'tags'])->latest()->paginate(5);

        return view('posts.mine', compact('posts'));
    }

    /**
     * Вернуть представление редактирования поста
     *
     * @param Post $post
     * @return View
     */
    public function showEdit(Post $post): View
    {
        return view('posts.edit', [
            'post'       => $post,
            'categories' => $this->categoryService->index(),
            'tags'       => $this->tagService->index(),
        ]);
    }

    /**
     * Обновить пост
     *
     * @param UpdatePostRequest $request
     * @param Post $post
     * @return RedirectResponse
     */
    public function update(UpdatePostRequest $request, Post $post): RedirectResponse
    {
        // Проверяем права пользователя на редактирование Поста
        $this->authorize('update', $post);

        // Обновляем Пост
        $this->postService->update($post, $request->validated());

        // Перенаправляем на страницу постов с успехом
        return redirect()->route('posts.mine')
            ->with('success', 'Пост успешно обновлён!');
    }

    /**
     * Опубликовать пост
     *
     * @param Post $post
     * @return RedirectResponse
     */
    public function publish(Post $post): RedirectResponse
    {
        // Проверяем права пользователя на редактирование Поста
        $this->authorize('update', $post);

        // Обновляем Пост
        $this->postService->update($post, ['is_published' => true]);

        // Перенаправляем на страницу постов с успехом
        return redirect()->route('posts.mine')
            ->with('success', 'Пост успешно опубликован!');
    }
}
