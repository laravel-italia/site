<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';

    /* Relationship Methods */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
