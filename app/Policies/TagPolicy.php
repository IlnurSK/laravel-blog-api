<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;

class TagPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // Право на просмотр списка тегов - все
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    // Право на просмотр конкретного тега - все
    public function view(User $user, Tag $tag): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    // Право на создание тега - только админ
    public function create(User $user): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the model.
     */
    // Право на обновление тега - только админ
    public function update(User $user, Tag $tag): bool
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the model.
     */
    // Право на удаление тега - только админ
    public function delete(User $user, Tag $tag): bool
    {
        return $user->is_admin;
    }
}
