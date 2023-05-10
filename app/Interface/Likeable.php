<?php

namespace App\Interface;

interface Likeable
{
  public function likes();
  public function addLike();
  public function unlike();
}
