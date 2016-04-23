<?php

namespace LaravelItalia\Domain;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Tag extends Model
{
    public static function createFromName($name)
    {
        $tag = new self();

        $tag->name = $name;
        $tag->slug = Str::slug($tag->name);

        return $tag;
    }

    public function threads()
    {
        return $this->belongsToMany(Thread::class);
    }
}
