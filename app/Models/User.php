<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\ImageTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Permission\Traits\HasPermissions;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles, HasPermissions, InteractsWithMedia, ImageTrait;

    protected $appends = ['profilePicture'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function metadata()
    {
        return $this->hasMany(UserMetadata::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getProfilePictureAttribute()
    {
        if ($this->hasMedia('profile-picture')) {
            return $this->getFirstMedia('profile-picture')->getUrl('profile-picture');
        }

        return env('APP_URL') . '/laravel-projects/laragramv2/storage/app/public/notset.png';
    }

    public function isBanned()
    {
        return false;
    }

    public function setUsernameAttribute($value)
    {
        $this->attributes['username'] = $value;
        $this->attributes['slug'] = $this->str_slug($value);
    }


    private function str_slug($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, '-');

        // remove duplicate -
        $text = preg_replace('~-+~', '-', $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    // Like Logic

    public function likePosts()
    {
        return $this->morphedByMany(Post::class, 'likable');
    }

    public function likeComments()
    {
        return $this->morphedByMany(Comment::class, 'likable');
    }

    public function likePost(Post $post, $like)
    {
        $likePosts = $this->likePosts();

        return $this->_like($likePosts, $post, $like);
    }

    public function likeComment(Comment $comment, $like)
    {
        $likeComments = $this->likeComments();

        return $this->_like($likeComments, $comment, $like);
    }

    private function _like($relationship, $model, $like)
    {
        if ($relationship->where('likable_id', $model->id)->exists()) {
            $relationship->updateExistingPivot($model, ['like' => $like]);
        } else {
            $relationship->attach($model, ['like' => $like]);
        }

        $model->load('likes');
        $unlike = (int) $model->unlike()->sum('like');
        $addLike = (int) $model->addLike()->sum('like');

        $model->likes_count = $addLike + $unlike;
        $model->save();

        return $model->likes_count;
    }

    // Media

    public function registerMediaConversions(Media $media = null): void
    {
        $this
            ->addMediaConversion('profile-thumbnail')
            ->fit(Manipulations::FIT_CROP, 25, 25)
            ->nonQueued();

        $this
            ->addMediaConversion('profile-picture')
            ->fit(Manipulations::FIT_CROP, 150, 150)
            ->nonQueued();

        $this
            ->addMediaConversion('story-picture')
            ->fit(Manipulations::FIT_CROP, 150, 150)
            ->nonQueued();
    }
}
