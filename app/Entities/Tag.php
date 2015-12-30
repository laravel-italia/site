<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function threads()
    {
        return $this->belongsToMany(Thread::class);
    }
}
