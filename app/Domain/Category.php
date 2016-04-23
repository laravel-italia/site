<?php

namespace LaravelItalia\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Category.
 */
class Category extends Model
{
    public static function createFromName($name)
    {
        $category = new self();
        $category->name = $name;
        $category->slug = Str::slug($name);
        return $category;
    }

    /* Relationship Methods */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
