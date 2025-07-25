<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    /**
     * Определяет, может ли пользователь создавать пост.
     *
     * @param User $user Пользователь
     * @return bool Разрешено ли действие
     */
    public function create(User $user): bool
    {
        return $user->exists;
    }

    /**
     * Определяет, может ли пользователь обновлять пост.
     *
     * @param User $user Пользователь
     * @param Post $post Пост
     * @return bool Разрешено ли действие
     */
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin;
    }

    /**
     * Определяет, может ли пользователь удалить пост.
     *
     * @param User $user Пользователь
     * @param Post $post Пост
     * @return bool Разрешено ли действие
     */
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin;
    }

    /**
     * Восстановление удалённого поста (не используется).
     *
     * @param User $user Пользователь
     * @param Post $post Пост
     * @return bool Разрешено ли действие
     */
    public function restore(User $user, Post $post): bool
    {
        return false;
    }

    /**
     * Полное удаление поста (не используется).
     *
     * @param User $user Пользователь
     * @param Post $post Пост
     * @return bool Разрешено ли действие
     */
    public function forceDelete(User $user, Post $post): bool
    {
        return false;
    }
}
