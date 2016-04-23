<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Reply;
use LaravelItalia\Domain\Thread;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

/**
 * Class ReplyRepository.
 */
class ReplyRepository
{
    public function getByThread(Thread $thread, $page)
    {
        return $thread->replies()->orderBy('created_at', 'ASC')->paginate(
            \Config::get('settings.forum.replies_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    public function save(Reply $reply)
    {
        if (!$reply->save()) {
            throw new NotSavedException();
        }
    }

    public function delete(Reply $reply)
    {
        if (!$reply->delete()) {
            throw new NotDeletedException();
        }
    }
}
