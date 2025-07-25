<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;

/**
 * Сервис для работы с комментариями.
 */
class CommentService
{
    /**
     * Создать новый комментарий.
     *
     * @param array{body: string} $data Данные для создания
     * @param Post $post Пост к которому создается комментарий
     * @param User $user Автор комментария
     * @return Comment Новый комментарий
     */
    public function create(array $data, Post $post, User $user): Comment
    {
        return $post->comments()->create([
            'body'    => $data['body'],
            'user_id' => $user->id,
        ]);
    }

    /**
     * Обновить комментарий.
     *
     * @param Comment $comment Комментарий, который нужно обновить
     * @param array{body: string} $data Данные для обновления
     * @return Comment Обновленный комментарий
     */
    public function update(Comment $comment, array $data): Comment
    {
        $comment->update($data);
        return $comment->fresh();
    }

    /**
     * Удалить комментарий.
     *
     * @param Comment $comment Комментарий, который нужно удалить
     * @return void
     */
    public function delete(Comment $comment): void
    {
        $comment->delete();
    }
}
