<?php

namespace LaravelItalia\Domain;

use Illuminate\Database\Eloquent\Model;

class Thread extends Model
{
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
