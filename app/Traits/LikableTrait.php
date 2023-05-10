<?php

namespace App\Traits;

use App\Models\User;

trait LikableTrait
{
  public function likes()
  {
    return $this->morphToMany(User::class, 'likables');
  }

  public function addLike()
  {
    return $this->likes()->wherePivot('like', 1);
  }

  public function unlike()
  {
    return $this->likes()->wherePivot('like', 0);
  }
}
