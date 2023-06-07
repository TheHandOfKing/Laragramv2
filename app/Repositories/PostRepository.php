<?php

namespace App\Repositories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class PostRepository
{
    public function postsWithUserAndCommentsNoUserMedia(): Collection
    {
        $posts = Post::with(['user' => function ($query) {
            $query->select(['id', 'name', 'email', 'slug', 'username']); // Add any other relevant fields
        }])->with('comments')->get();

        $posts->each(function ($post) {
            $post->user->withoutMedia();
        });

        return $posts;
    }
}
