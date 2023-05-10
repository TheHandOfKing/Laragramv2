<?php

namespace App\Http\Controllers;

use App\Interface\Likeable;

class LikesController extends Controller
{
    public function like(Likeable $likeable, $like)
    {
        // Find existing like
        $existingLike = $likeable->likes()->where('user_id', auth()->user()->id)->first();

        // If the like already exists, update it
        if ($existingLike) {
            $existingLike->pivot->like = $like;
            $existingLike->pivot->save();
        }
        // Otherwise, create a new like
        else {
            $likeable->likes()->attach(auth()->user()->id, ['like' => $like]);
        }

        // Refresh likes
        $likeable->load('likes');
        $unlike = (int) $likeable->unlike()->count();
        $addLike = (int) $likeable->addLike()->count();

        // Update likes count
        $likeable->likes_count = $addLike - $unlike;
        $likeable->save();

        return $likeable->likes_count;
    }
}
