<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;
use LaravelItalia\Reply;

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
}
