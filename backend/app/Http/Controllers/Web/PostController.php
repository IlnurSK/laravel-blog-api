<?php

declare(strict_types=1);

namespace App\Http\Controllers\Web;

use App\Models\Post;

class PostController
{
    public function show(Post $post)
    {
        $post->load(['user', 'category', 'tags', 'comments.user']);

        return view('posts.show', compact('post'));
    }
}
