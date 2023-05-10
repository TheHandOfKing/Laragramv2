<?php

namespace App\Http\Controllers;

use App\Interface\Likeable;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class LikesController extends Controller
{
    public function like(Request $request, $model, $id)
    {
        $modelInstance = $this->getModelInstance($model, $id);

        $user = auth()->user();
        // Find existing like
        if ($model == 'post') {
            $user->likeInstance($modelInstance, 1);
        }
    }

    public function getLike($model, $id)
    {
        $user = auth()->user();

        $likes = null;

        switch ($model) {
            case 'post':
                $likes = $user->likePosts()->where('likables_id', $id)->first();
                break;
            case 'comment':
                $likes = $user->likeComments()->where('likables_id', $id)->first();
                break;
        }

        if (!isset($likes)) {
            return response()->json([
                'status' => 200,
                'liked' => false,
            ]);
        }

        return response()->json([
            'status' => 200,
            'liked' => true,
        ]);
    }

    private function getModelInstance($model, $id)
    {
        $class = match ($model) {
            'post' => Post::class,
            'comment' => Comment::class,
            default => abort(400, 'Invalid model type'),
        };

        return $class::findOrFail($id);
    }
}
