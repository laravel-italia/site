<?php

namespace LaravelItalia\Entities;

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
}
