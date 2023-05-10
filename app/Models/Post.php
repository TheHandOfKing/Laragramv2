<?php

namespace App\Models;

use App\Interface\Likeable;
use App\Traits\ImageTrait;
use App\Traits\LikableTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia, Likeable
{
    use HasFactory, InteractsWithMedia, ImageTrait, LikableTrait;

    protected $appends = ['mainImage'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderBy('likes_count', 'DESC');
    }

    public function pinComment(Comment $comment)
    {
        $this->pinned_comment_id = $comment->id;

        $this->save();
    }

    public function saved_posts()
    {
        return $this->belongsToMany(User::class, 'saved_posts')->withTimestamps();
    }

    public function isSaved()
    {
        return $this->saved_posts()->where('user_id', Auth::id())->count() > 0;
    }

    // Getters 

    public function getIsSavedAttribute()
    {
        return $this->isSaved();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function getRouteKeyName()
    {
        return 'slug';
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

    // Media

    public function getMainImageAttribute()
    {
        if ($this->hasMedia('post-image'))
            return $this->getFirstMedia('post-image')->getUrl();
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('post-image')
            ->fit(Manipulations::FIT_CROP, 293, 293)
            ->nonQueued();

        $this
            ->addMediaConversion('post-full-picture')
            ->fit(Manipulations::FIT_CROP, 800, 800)
            ->nonQueued();

        $this
            ->addMediaConversion('feed-picture')
            ->fit(Manipulations::FIT_CROP, 468, 595)
            ->nonQueued();
    }
}
