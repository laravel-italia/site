<?php

namespace LaravelItalia\Domain;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

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

    public function articles()
    {
        return $this->belongsToMany(Article::class);
    }
}
