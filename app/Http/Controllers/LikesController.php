<?php

namespace App\Http\Controllers;

use App\Interface\Likeable;
use App\Models\Comment;
use App\Models\Post;
use App\Services\ModelService;
use Illuminate\Http\Request;

use function PHPUnit\Framework\isEmpty;

class LikesController extends Controller
{
    public function like(Request $request, $model, $id)
    {
        $modelInstance = ModelService::getModelInstance($model, $id);

        $user = auth()->user();
        // Find existing like

        if ($request->query('unlike') === 'true') {
            $user->likeInstance($modelInstance, 0);

            if (!isset($likes)) {
                return response()->json([
                    'status' => 200,
                    'liked' => false,
                ]);
            }
        }


        $user->likeInstance($modelInstance, 1);
    }

    public function getLike($model, $id)
    {
        $user = auth()->user();

        $likes = null;

        switch ($model) {
            case 'post':
                $likes = $user->likePosts()->where('likables_id', $id)->where('like', 1)->first();
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
}
