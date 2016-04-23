<?php

namespace LaravelItalia\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Series.
 */
class Series extends Model
{
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

    /**
     * @var string
     */
    protected $table = 'series';

    /* Eloquent Scopes */

    /**
     * @param $query
     *
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
