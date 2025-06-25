<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Метод получения всех Тегов
    public function index()
    {
        return Tag::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    // Метод получения нового Тега
    public function store(StoreTagRequest $request)
    {
        // Получаем экземпляр нового отвалидированного Тега
        $tag = Tag::create($request->validated());

        // Возвращаем новый Тег в JSON со статусом 201
        return response()->json($tag, 201);
    }

    /**
     * Display the specified resource.
     */

    // Метод получения конкретного Тега
    public function show(Tag $tag)
    {
        return $tag;
    }

    /**
     * Update the specified resource in storage.
     */
    // Метод обновления Тега
    public function update(UpdateTagRequest $request, Tag $tag)
    {
        // Обновляем текущий Тег валидированными данными
        $tag->update($request->validated());

        // Возвращаем обновленный Тег в JSON
        return response()->json($tag);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Метод удаления текущего Тега
    public function destroy(Tag $tag)
    {
        $tag->delete();

        return response()->json(['message' => 'Tag deleted']);
    }
}
