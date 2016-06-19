<?php

namespace LaravelItalia\Domain\Repositories;

use Config;
use LaravelItalia\Domain\Media;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

class MediaRepository
{
    /**
     * Restituisce un elenco dei media esistenti, paginati.
     *
     * @param $page
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($page)
    {
        return Media::with(['user'])
            ->paginate(
                Config::get('settings.publications.media_per_page'),
                ['*'],
                'page',
                $page
            );
    }

    /**
     * Restituisce un media dato il suo id.
     *
     * @param $id
     * @return mixed
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $media = Media::find($id);

        if (!$media) {
            throw new NotFoundException();
        }

        return $media;
    }

    /**
     * Salva un nuovo media $media su database.
     *
     * @param Media $media
     * @throws NotSavedException
     */
    public function save(Media $media)
    {
        if (!$media->save()) {
            throw new NotSavedException();
        }
    }

    /**
     * Cancella il media $media dal database.
     *
     * @param Media $media
     * @throws NotDeletedException
     * @throws \Exception
     */
    public function delete(Media $media)
    {
        if (!$media->delete()) {
            throw new NotDeletedException();
        }
    }
}
