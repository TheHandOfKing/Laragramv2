<?php

namespace App\Http\Controllers;

use App\Interface\Likeable;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class LikesController extends Controller
{
    public function like(Request $request, $model, $id)
    {
        $class = match ($model) {
            'post' => Post::class,
            'comment' => Comment::class,
            default => abort(400, 'Invalid model type'),
        };

        $modelInstance = $class::findOrFail($id);

        $user = auth()->user();
        // Find existing like
        if ($model == 'post') {
            $user->likeInstance($modelInstance, 1);
        }
    }
}
