<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    /* Relationship Utility Methods */

    public function setUser(User $user)
    {
        $this->user()->associate($user);
    }

    public function setUrl($url)
    {
        $this->url = $url;
    }

    /* Relationship Methods */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
