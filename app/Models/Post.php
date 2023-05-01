<?php

namespace App\Models;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, ImageTrait;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function setValues(): void
    {
        $request = request();

        $this->description = $request->input('description', '') ?? '';
        $this->location = $request->input('location', '-1') ?? '-1';
        $this->user_id = $request->input('user_id', '-1') ?? '-1';
        $this->no_comments = $request->input('no_comments', '') ?? '';
        $this->likes_view = $request->input('likes_view', '') ?? '';
        $this->slug = $this->generateRandomString();

        $this->save();
    }

    function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }

        return $randomString;
    }
}
