<?php

namespace LaravelItalia\Domain;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Article extends Model
{
    public static function createFromData($title, $digest, $body, $metaDescription)
    {
        $article = new self();

        $article->title = $title;

        $article->digest = $digest;
        $article->body = $body;

        $article->metadescription = $metaDescription;

        $article->published_at = null;

        return $article;
    }

    public function isPublished()
    {
        return !is_null($this->published_at);
    }

    public function publish($publicationDate)
    {
        $this->published_at = $publicationDate;
    }

    public function unpublish()
    {
        $this->published_at = null;
    }

    /* Eloquent Scopes */

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    public function scopeVisible($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    /* Mutators */

    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /* Relationship Utility Methods */

    public function setUser(User $user)
    {
        $this->user()->associate($user);
    }

    public function setSeries($series)
    {
        $this->series()->associate($series);
    }

    public function syncCategories(Collection $categories)
    {
        if (!$this->exists) {
            throw new \Exception('record_not_exists');
        }

        $this->categories()->sync($categories);
    }

    public function isPartOfSeries()
    {
        return $this->series_id !== null;
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
}
