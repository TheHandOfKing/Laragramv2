<?php

namespace App\Traits;

trait ImageTrait
{
  public function setImages($collection): void
  {
    $request = request();
    $files = $request->file('files');

    if ($files == null)
      return;

    foreach ($files as $file) {
      $name = sha1(time() . $file->getClientOriginalName());
      $ext = $file->clientExtension();

      $this
        ->addMedia($file->getPathname())
        ->usingFileName("$name.$ext")
        ->toMediaCollection($collection);
    }
  }
}
