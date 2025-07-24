<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class TagController extends Controller
{
    // Инициализируем сервисы
    public function __construct(
        private readonly TagService $tagService,
    )
    {
    }

    /**
     * Вернуть представление со списком тегов
     *
     * @return View
     */
    public function index(): View
    {
        // Получаем все теги
        $tags = $this->tagService->index();

        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Вернуть представление создания нового тега
     *
     * @return View
     */
    public function create(): View
    {
        return view('admin.tags.create');
    }

    /**
     * Сохранить новый тег
     *
     * @param StoreTagRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTagRequest $request): RedirectResponse
    {
        // Используя сервис создаем новую тег
        $this->tagService->create($request->validated());

        // Перенаправляем на страницу тегов с уведомлением
        return redirect()->route('admin.tags.index')
            ->with('success', 'Тег добавлен');
    }

    /**
     * Вернуть представление редактирования тега
     *
     * @param Tag $tag
     * @return View
     */
    public function edit(Tag $tag): View
    {
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Обновить тег
     *
     * @param UpdateTagRequest $request
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function update(UpdateTagRequest $request, Tag $tag): RedirectResponse
    {
        // Используя сервис обновляем тег, передав туда новые данные
        $this->tagService->update($tag, $request->validated());

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.tags.index')
            ->with('success', 'Тег обновлен');
    }

    /**
     * Удалить тег
     *
     * @param Tag $tag
     * @return RedirectResponse
     */
    public function destroy(Tag $tag): RedirectResponse
    {
        // Используя сервис удаляем тег
        $this->tagService->delete($tag);

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.tags.index')
            ->with('success', 'Тег удален');
    }
}
