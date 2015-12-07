<?php

namespace LaravelItalia\Entities\Repositories;


use \Config;
use LaravelItalia\Entities\Media;

/**
 * Class MediaRepository
 * @package LaravelItalia\Entities\Repositories
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
        return Media::find($id);
    }

    public function save(Media $media)
    {
        $media->save();
    }

    public function remove(Media $media)
    {
        $media->delete();
    }
}