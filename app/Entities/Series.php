<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Series
 * @package LaravelItalia\Entities
 */
class Series extends Model
{
    /**
     * @var string
     */
    protected $table = 'series';

    /* Eloquent Scopes */

    /**
     * @param $query
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', '=', true);
    }

    /* Relationship Methods */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
