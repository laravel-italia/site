<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 * @package LaravelItalia\Entities
 */
class Category extends Model
{
    /* Relationship Methods */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
