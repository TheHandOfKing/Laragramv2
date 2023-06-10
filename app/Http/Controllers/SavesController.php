<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ModelService;

class SavesController extends Controller
{
    public function save(Request $request, $model, $id)
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
}
