<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Tag;
use LaravelItalia\Entities\Thread;

/**
 * Class TagObserver.
 */
class TagObserver
{
    /**
     * @param Tag $tag
     */
    public function deleting(Tag $tag)
    {
        $threads = $tag->threads()->get();

        foreach($threads as $thread)
        {
            /* @var $thread Thread */
            if(count($thread->tags()->get()) == 1) {
                $thread->delete();
            }
        }
    }
}
