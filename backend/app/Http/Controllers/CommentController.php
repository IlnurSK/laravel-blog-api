<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Http\Requests\UpdateCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // Метод получения всех Комментов Поста
    public function index(Post $post)
    {
        // Возвращаем все Комменты со связанными данными, в виде постраничного списка
        $comments = $post->comments()->with(['user'])->latest()->paginate(10);

        return CommentResource::collection($comments);
    }

    /**
     * Store a newly created resource in storage.
     */
    // Метод сохранения нового Коммента
    public function store(StoreCommentRequest $request, Post $post)
    {
        // Создание нового Коммента (валидированного) к Посту, с привязкой ID юзера
        $comment = $post->comments()->create([
            'body'    => $request->validated('body'),
            'user_id' => Auth::id(),
        ]);

        // Предзагружаем связанные данные по Юзеру
        $comment->load('user');

        // Возвращаем новый Коммент в виде ресурса
        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     */
    // Метод получения конкретного Коммента
    public function show(Post $post, Comment $comment)
    {
        // Проверяем существование коммента
        if ($comment->post_id !== $post->id) {
            return response()->json(['message' => 'Comment not found in this post'], 404);
        }
        // Возвращаем конкретный Коммент со связанными данными
        $comment->load(['user']);
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     */
    // Метод обновления Коммента
    public function update(UpdateCommentRequest $request, Post $post, Comment $comment)
    {
        // Проверям существование коммента и является ли юзер владельцем
        if ($comment->post_id !== $post->id || $comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Обновляем Комментарий
        $comment->update($request->validated());

        // Предзагружаем связанные данные
        $comment->load('user');

        // Возвращаем обновленный Комментарий в виде ресурса
        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    // Метод удаления Коммента
    public function destroy(Post $post, Comment $comment)
    {
        // Проверям существование коммента и является ли юзер владельцем
        if ($comment->post_id !== $post->id || $comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        // Удаляем Коммент
        $comment->delete();

        // Возвращаем сообщение об успехе
        return response()->json(['message' => 'Comment deleted']);
    }
}
