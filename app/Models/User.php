<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Interface\Likeable;
use App\Traits\ImageTrait;
use App\Traits\LikableTrait;
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

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    /**
     * A user can have many messages
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id')->withTimestamps();
    }

    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id')->withTimestamps();
    }

    public function metadata()
    {
        return $this->hasMany(UserMetadata::class);
    }

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    // Like Logic
    public function likePosts()
    {
        return $this->morphedByMany(Post::class, 'likables');
    }

    public function likeComments()
    {
        return $this->morphedByMany(Comment::class, 'likables');
    }


    public function getRouteKeyName()
    {
        return 'slug';
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

    public function canViewProfile(User $user)
    {
        return !$this->private || $user->is($this) || $user->following->contains($this);
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

    /**
     * Liking functionality.
     *
     * @param $modelInstance
     * @param $like
     * @return void
     */
    public function likeInstance(Likeable $instance, $like)
    {
        $relationshipMethod = 'like' . class_basename(get_class($instance)) . 's';

        if (!method_exists($this, $relationshipMethod)) {
            throw new \Exception('This user cannot like instances of ' . get_class($instance));
        }

        $relationship = $this->$relationshipMethod();

        return $this->_like($relationship, $instance, $like);
    }

    private function _like($relationship, $model, $like)
    {
        if ($relationship->where('likables_id', $model->id)->exists()) {
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

    public function withoutMedia()
    {
        return $this->makeHidden(['media']);
    }

    public function getProfilePictureAttribute()
    {
        if ($this->hasMedia('profile-picture')) {
            return $this->getFirstMedia('profile-picture')->getUrl('profile-picture');
        }

        return env('APP_URL') . '/laravel-projects/laragramv2/storage/app/public/notset.png';
    }


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
