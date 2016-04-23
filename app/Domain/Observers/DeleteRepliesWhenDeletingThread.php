<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Thread;
use LaravelItalia\Domain\Reply;

/**
 * Class DeleteRepliesWhileDeletingThread.
 */
class DeleteRepliesWhenDeletingThread
{
    /**
     * @param Thread $thread
     */
    public function deleting(Thread $thread)
    {
        $replies = $thread->replies()->get();

        /* @var $reply Reply */
        foreach ($replies as $reply) {
            $reply->delete();
        }
    }
}
