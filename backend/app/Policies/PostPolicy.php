<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // Право на создание поста - только авторизованные юзеры
    public function create(User $user): bool
    {
        return $user->exists;
    }

    // Право на обновление поста - только автор или админ
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin;
    }

    // Право на удаление поста - только автор или админ
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id || $user->is_admin;
    }
}
