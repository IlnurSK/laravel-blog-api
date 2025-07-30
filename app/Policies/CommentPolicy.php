<?php

namespace App\Policies;

use App\Models\Comment;
use App\Models\User;

class CommentPolicy
{
    /**
     * Определяет, может ли пользователь обновлять комментарий.
     *
     * @param User $user Пользователь
     * @param Comment $comment Комментарий
     * @return bool Разрешено ли действие
     */
    public function update(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id;
    }

    /**
     * Определяет, может ли пользователь удалить комментарий.
     *
     * @param User $user Пользователь
     * @param Comment $comment Комментарий
     * @return bool Разрешено ли действие
     */
    public function delete(User $user, Comment $comment): bool
    {
        return $user->id === $comment->user_id || $user->is_admin;
    }

    /**
     * Восстановление удалённого комментария (не используется).
     *
     * @param User $user Пользователь
     * @param Comment $comment Комментарий
     * @return bool Разрешено ли действие
     */
    public function restore(User $user, Comment $comment): bool
    {
        return false;
    }

    /**
     * Полное удаление комментария (не используется).
     *
     * @param User $user Пользователь
     * @param Comment $comment Комментарий
     * @return bool Разрешено ли действие
     */
    public function forceDelete(User $user, Comment $comment): bool
    {
        return false;
    }
}
