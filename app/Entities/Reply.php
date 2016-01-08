<?php

namespace LaravelItalia;

use Illuminate\Database\Eloquent\Model;
use LaravelItalia\Entities\Thread;
use LaravelItalia\Entities\User;

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
