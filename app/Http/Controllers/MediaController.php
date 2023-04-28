<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class MediaController extends Controller
{
    public function store(Request $request, string $modelType, int $modelId, $collection = 'default'): JsonResponse|RedirectResponse
    {
        $modelClass = 'App\\Models\\' . ucfirst($modelType);
        $model = $modelClass::findOrFail($modelId);

        $media = $model->setImages($collection);

        $images = $model->getMedia();

        $media = array();

        $imageData = array();
        foreach ($images as $image) {
            $media[] = $image->getUrl();
            $imageData[] = $image->getAttributes();
        }

        if ($request->expectsJson()) {
            return Response::json([
                'imageData' => $imageData,
                'images' => $media
            ]);
        }

        return redirect()->back();
    }

    public function destroy(Request $request, Media $media): JsonResponse|RedirectResponse
    {
        $media->delete();

        if ($request->expectsJson()) {
            return Response::json([
                'message' => 'Image deleted successfully',
            ]);
        }

        return redirect()->back();
    }
}
