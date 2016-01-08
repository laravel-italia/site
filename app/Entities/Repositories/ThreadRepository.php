<?php

namespace LaravelItalia\Entities\Repositories;

use LaravelItalia\Entities\Thread;
use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

/**
 * Class ThreadRepository.
 */
class ThreadRepository
{
    public function getAll($page)
    {
        $query = Thread::with(['tags'])->orderBy('created_at', 'DESC');

        return $query->paginate(
            \Config::get('settings.forum.threads_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    public function getByTags(Collection $tags, $page)
    {
        $query = Thread::with(['tags'])
            ->getQuery()
            ->join('tag_thread', 'threads.id', '=', 'tag_thread.thread_id')
            ->whereIn(
                'tag_thread.tag_id',
                $tags->lists('id')
            );

        $query->groupBy('threads.id')
            ->orderBy('threads.created_at', 'DESC');

        return $query->paginate(
            \Config::get('settings.forum.threads_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    public function save(Thread $thread)
    {
        if (!$thread->save()) {
            throw new NotSavedException();
        }
    }

    public function delete(Thread $thread)
    {
        if (!$thread->delete()) {
            throw new NotDeletedException();
        }
    }
}
