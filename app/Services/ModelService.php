<?php

namespace App\Services;

class ModelService
{
  /**
   * Get data of the other chatters for a given user.
   *
   * @param  User  $user
   * @return array
   */
  public static function getModelInstance($model, $id)
  {
    $class = match ($model) {
      'post' => Post::class,
      'comment' => Comment::class,
      default => abort(400, 'Invalid model type'),
    };

    return $class::findOrFail($id);
  }
}
