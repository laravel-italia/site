<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Tag;
use LaravelItalia\Entities\Thread;

/**
 * Class DeleteThreadsWithoutAssociatedTags.
 */
class DeleteThreadsWithoutAssociatedTags
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
            $thread->tags()->detach($tag->id);

            if(count($thread->tags()->get()) == 1) {
                $thread->delete();
            }
        }
    }
}
