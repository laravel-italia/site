<?php

namespace LaravelItalia\Domain;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

/**
 * Class Article.
 */
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

    /**
     * @return bool
     */
    public function isPublished()
    {
        return !is_null($this->published_at);
    }

    /**
     * @param $publicationDate
     */
    public function publish($publicationDate)
    {
        $this->published_at = $publicationDate;
    }

    /**
     *
     */
    public function unpublish()
    {
        $this->published_at = null;
    }

    /* Eloquent Scopes */

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }

    /**
     * @param $query
     *
     * @return mixed
     */
    public function scopeVisible($query)
    {
        return $query->where('published_at', '<=', Carbon::now());
    }

    /* Mutators */

    /**
     * Sets the article slug everytime the title is changed.
     *
     * @param  string  $value
     * @return string
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    /* Relationship Utility Methods */

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user()->associate($user);
    }

    /**
     * @param Series $series
     */
    public function setSeries(Series $series)
    {
        $this->series()->associate($series);
    }

    /**
     * @param Collection $categories
     *
     * @throws \Exception
     */
    public function syncCategories(Collection $categories)
    {
        if (!$this->exists) {
            throw new \Exception('record_not_exists');
        }

        $this->categories()->sync($categories);
    }

    /**
     * @return bool
     */
    public function isPartOfSeries()
    {
        return $this->series_id !== null;
    }

    /* Relationship Methods */

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function series()
    {
        return $this->belongsTo(Series::class);
    }
}
