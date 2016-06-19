<?php

namespace LaravelItalia\Domain;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    /* Relationship Utility Methods */

    public function setUser(User $user)
    {
        $this->user()->associate($user);
    }

    /* Relationship Methods */

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
