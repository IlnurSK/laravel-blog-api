<?php

namespace App\Policies;

use App\Models\Category;
use App\Models\User;

class CategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // Право на просмотр списка категорий - все
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    // Право на просмотр конкретной категории - все
    public function view(User $user, Category $category): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    // Право на создание категории - только админ
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    // Право на обновление категории - только админ
    public function update(User $user, Category $category): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    // Право на удаление категории - только админ
    public function delete(User $user, Category $category): bool
    {
        return $user->is_admin;
    }
}
