<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Chat extends Model
{
    use HasFactory;

    /**
     * Get the messages associated with the user, ordered by creation date.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages(): HasMany
    {
        // The messages are ordered by creation date in descending order. 
        // This means that the newest messages will be returned first.
        return $this->hasMany(Message::class)->orderBy('created_at', 'desc');;
    }
}
