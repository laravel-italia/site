<?php

namespace LaravelItalia\Entities;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    public function isPublished()
    {
        return (!is_null($this->published_at));
    }

    public function getPublicationDate()
    {
        return $this->published_at;
    }

    public function publish($publicationDate)
    {
        $this->is_published = true;
        $this->published_at = $publicationDate;
    }

    public function unpublish()
    {
        $this->is_published = false;
        $this->published_at = null;
    }

    /* Relationship Methods */

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    public function series()
    {
        return $this->belongsTo(Series::class);
    }

    /* Relationship Utility Methods */
    public function setUser(User $user)
    {
        $this->user()->associate($user);
    }

    public function setSeries(Series $series)
    {
        $this->series()->associate($series);
    }

    public function syncCategories(Collection $categories)
    {
        if(!$this->exists)
            throw new \Exception('record_not_exists');

        $this->categories()->sync($categories);
    }

    public function isPartOfSeries()
    {
        return ($this->series_id !== null);
    }
}
