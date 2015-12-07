<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';

    /* Eloquent Scopes */
    public function scopePublished($query)
    {
        return $query->where('is_published', '=', true);
    }

    /* Relationship Methods */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
