<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    /**
     * Определяет, может ли пользователь просматривать список тегов.
     *
     * @param User $user Пользователь
     * @return bool Разрешено ли действие
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Определяет, может ли пользователь просматривать конкретный тег.
     *
     * @param User $user Пользователь
     * @param Tag $tag Тег
     * @return bool Разрешено ли действие
     */
    public function view(User $user, Tag $tag): bool
    {
        return true;
    }

    /**
     * Определяет, может ли пользователь создавать тег.
     *
     * @param User $user Пользователь
     * @return bool Разрешено ли действие
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Определяет, может ли пользователь обновлять тег.
     *
     * @param User $user Пользователь
     * @param Tag $tag Тег
     * @return bool Разрешено ли действие
     */
    public function update(User $user, Tag $tag): bool
    {
        return $user->is_admin;
    }

    /**
     * Определяет, может ли пользователь удалить категорию.
     *
     * @param User $user Пользователь
     * @param Tag $tag Тег
     * @return bool Разрешено ли действие
     */
    public function delete(User $user, Tag $tag): bool
    {
        return $user->is_admin;
    }

    /**
     * Восстановление удалённого тега (не используется).
     *
     * @param User $user Пользователь
     * @param Tag $tag Тег
     * @return bool Разрешено ли действие
     */
    public function restore(User $user, Tag $tag): bool
    {
        return false;
    }

    /**
     * Полное удаление тега (не используется).
     *
     * @param User $user Пользователь
     * @param Tag $tag Тег
     * @return bool Разрешено ли действие
     */
    public function forceDelete(User $user, Tag $tag): bool
    {
        return false;
    }
}
