<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use App\Services\TagService;

class TagController extends Controller
{
    // Инициализируем сервис
    public function __construct(
        private readonly TagService $tagService,
    )
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Получаем все теги
        $tags = $this->tagService->index();

        // Возвращаем вид, передав туда данные
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Возвращаем вид создания тегов
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTagRequest $request)
    {
        // Используя сервис создаем новую тег
        $this->tagService->create($request->validated());

        // Перенаправляем на страницу тегов с уведомлением
        return redirect()->route('admin.tags.index')->with('success', 'Тег добавлен');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Tag $tag)
    {
        // Возвращаем представление редактирования тегов, передавая туда тег
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        // Используя сервис обновляем тег, передав туда новые данные
        $this->tagService->update($tag, $request->validated());

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.tags.index')->with('success', 'Тег обновлен');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Tag $tag)
    {
        // Используя сервис удаляем тег
        $this->tagService->delete($tag);

        // Перенаправляем на индексную страницу с уведомлением
        return redirect()->route('admin.tags.index')->with('success', 'Тег удален');
    }
}
