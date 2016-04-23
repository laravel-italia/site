<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Tag;
use LaravelItalia\Domain\Thread;

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

        foreach ($threads as $thread) {
            /* @var $thread Thread */
            $thread->tags()->detach($tag->id);

            if (count($thread->tags()->get()) == 1) {
                $thread->delete();
            }
        }
    }
}
