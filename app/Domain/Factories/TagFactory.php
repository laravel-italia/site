<?php

namespace LaravelItalia\Domain\Factories;

use Illuminate\Support\Str;
use LaravelItalia\Domain\Tag;

/**
 * Class TagFactory.
 */
class TagFactory
{
    /**
     * @param $name
     *
     * @return Tag
     */
    public static function createTag($name)
    {
        $tag = new Tag();

        $tag->name = $name;
        $tag->slug = Str::slug($tag->name);

        return $tag;
    }
}
