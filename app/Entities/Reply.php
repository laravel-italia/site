<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
