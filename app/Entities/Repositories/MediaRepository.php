<?php

namespace LaravelItalia\Entities\Repositories;

use Config;
use LaravelItalia\Entities\Media;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;

/**
 * Class MediaRepository.
 */
class MediaRepository
{
    public function getAll($page)
    {
        return Media::with(['user'])
            ->paginate(
                Config::get('publications.media_per_page'),
                ['*'],
                'page',
                $page
            );
    }

    public function findById($id)
    {
        $media = Media::find($id);

        if (!$media) {
            throw new NotFoundException();
        }

        return $media;
    }

    public function save(Media $media)
    {
        if (!$media->save()) {
            throw new NotSavedException();
        }
    }

    public function delete(Media $media)
    {
        if (!$media->delete()) {
            throw new NotDeletedException();
        }
    }
}
