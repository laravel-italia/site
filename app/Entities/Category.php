<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /* Relationship Methods */

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
