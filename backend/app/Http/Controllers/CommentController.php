<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Метод получения всех Комментов
    public function index()
    {
        // Возвращаем все Комменты со связанными данными, в виде постраничного списка
        return Comment::with(['user', 'post'])->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    // Метод сохранения нового Коммента
    public function store(StoreCommentRequest $request)
    {
        // Создание нового Коммента (валидированного) от имени текущего аутентифицированного пользователя
        $comment = $request->user()->comments()->create($request->validated());

        // Возвращаем новый Коммент с данными по пользователю (для фронта) и статусом 201 Created
        return response()->json($comment->load(['user']), 201);
    }

    /**
     * Display the specified resource.
     */
    // Метод получения конкретного Коммента
    public function show(Comment $comment)
    {
        // Возвращаем конкретный Коммент со связанными данными
        return $comment->load(['user', 'post']);
    }

    /**
     * Update the specified resource in storage.
     */
    // Метод обновления Коммента
    public function update(UpdateCommentRequest $request, Comment $comment)
    {
        // Проверяем что Коммент принадлежит текущему пользователю
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Обновляем Комментарий
        $comment->update($request->validated());

        // Возвращаем обновленный Комментарий
        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Метод удаления Коммента
    public function destroy(Request $request, Comment $comment)
    {
        // Проверяем что Коммент принадлежит текущему пользователю
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Удаляем Коммент
        $comment->delete();

        // Возвращаем сообщение об успехе
        return response()->json(['message' => 'Comment deleted']);
    }
}
