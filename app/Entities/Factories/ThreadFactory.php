<?php

namespace LaravelItalia\Entities\Factories;


use Illuminate\Support\Str;
use LaravelItalia\Entities\Thread;

class ThreadFactory
{
    public static function createThread($title)
    {
        $thread = new Thread;

        $thread->title = $title;
        $thread->slug = time() . '-' . Str::slug($title);

        $thread->is_closed = false;

        return $thread;
    }
}