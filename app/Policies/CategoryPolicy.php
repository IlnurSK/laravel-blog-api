<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Определяет, может ли пользователь просматривать список категорий.
     *
     * @param User $user Пользователь
     * @return bool Разрешено ли действие
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Определяет, может ли пользователь просматривать конкретную категорию.
     *
     * @param User $user Пользователь
     * @param Category $category Категория
     * @return bool Разрешено ли действие
     */
    public function view(User $user, Category $category): bool
    {
        return true;
    }

    /**
     * Определяет, может ли пользователь создавать категории.
     *
     * @param User $user Пользователь
     * @return bool Разрешено ли действие
     */
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Определяет, может ли пользователь обновлять категорию.
     *
     * @param User $user Пользователь
     * @param Category $category Категория
     * @return bool Разрешено ли действие
     */
    public function update(User $user, Category $category): bool
    {
        return $user->is_admin;
    }

    /**
     * Определяет, может ли пользователь удалить категорию.
     *
     * @param User $user Пользователь
     * @param Category $category Категория
     * @return bool Разрешено ли действие
     */
    public function delete(User $user, Category $category): bool
    {
        return $user->is_admin;
    }

    /**
     * Восстановление удалённой категории (не используется).
     *
     * @param User $user Пользователь
     * @param Category $category Категория
     * @return bool Разрешено ли действие
     */
    public function restore(User $user, Category $category): bool
    {
        return false;
    }

    /**
     * Полное удаление категории (не используется).
     *
     * @param User $user Пользователь
     * @param Category $category Категория
     * @return bool Разрешено ли действие
     */
    public function forceDelete(User $user, Category $category): bool
    {
        return false;
    }
}
