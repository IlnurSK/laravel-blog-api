<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

class CommentService
{
    public function create(array $data, Post $post, User $user): Comment
    {
        // Создание нового Коммента (валидированного) к Посту, с привязкой ID юзера
        return $post->comments()->create([
            'body'    => $data['body'],
            'user_id' => $user->id,
        ]);
    }

    public function update(Comment $comment, array $data): Comment
    {
        // Обновляем Комментарий
        $comment->update($data);
        return $comment->fresh();
    }

    public function delete(Comment $comment): void
    {
        // Удаляем Коммент
        $comment->delete();
    }

}
