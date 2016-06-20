<?php

namespace LaravelItalia\Domain;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Series extends Model
{
    protected $table = 'series';

    public static function createFromTitleAndDescriptionAndMetaDescription($title, $description, $metaDescription)
    {
        $series = new self();

        $series->title = $title;
        $series->description = $description;
        $series->metadescription = $metaDescription;

        $series->is_published = false;
        $series->is_completed = false;

        $series->slug = Str::slug($series->title);

        return $series;
    }

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
