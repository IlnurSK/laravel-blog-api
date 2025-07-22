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

        // Возвращаем перенаправление на страницу постов с сообщением об успехе
        return redirect()->route('posts.mine')->with('success', 'Пост создан');
    }

    // Метод удаления поста
    public function destroy(Post $post)
    {
        // Проверка прав на удаление (только свой пост)
        $this->authorize('delete', $post);

        // Удаляем через сервис пост
        $this->postService->delete($post);

        // Перенаправляем на страницу постов с успехом
        return redirect()->route('posts.mine')->with('success', 'Пост удалён');
    }


    // Метод отображения представления с постами юзера
    public function mine()
    {
        // Получаем все посты авторизованного пользователя, с сортировкой по дате и пагинацией
        $posts = Auth::user()->posts()->with(['category', 'tags'])->latest()->paginate(5);

        // Возвращаем представление и передаем туда данные
        return view('posts.mine', compact('posts'));
    }

    // Метод отображения представления редактирования поста
    public function showEdit(Post $post)
    {
        return view('posts.edit', [
            'post' => $post,
            'categories' => $this->categoryService->index(),
            'tags' => $this->tagService->index(),
        ]);
    }

    // Метод обновления поста
    public function update(UpdatePostRequest $request, Post $post)
    {
        // Проверям права пользователя на редактирование Поста
        $this->authorize('update', $post);

        // Обновляем Пост
        $this->postService->update($post, $request->validated());

        // Возвращаем обновленный Пост в виде ресурса
        return redirect()->route('posts.mine')->with('success', 'Пост успешно обновлён!');
    }

    // Метод публикации поста
    public function publish(Post $post)
    {
        // Проверям права пользователя на редактирование Поста
        $this->authorize('update', $post);

        // Обновляем Пост
        $this->postService->update($post, ['is_published' => true]);

        // Возвращаем обновленный Пост в виде ресурса
        return redirect()->route('posts.mine')->with('success', 'Пост успешно опубликован!');
    }

}
