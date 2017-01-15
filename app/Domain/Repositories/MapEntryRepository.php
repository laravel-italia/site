<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\MapEntry;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;

class MapEntryRepository
{
    public function getPublishedEntries($page)
    {
        return MapEntry::where('is_confirmed', '=', true)
            ->orderBy('created_at', 'desc')
            ->paginate(
                12,
                ['*'],
                'page',
                $page
            );
    }

    public function findByConfirmationToken($token)
    {
        $mapEntry = MapEntry::where('confirmation_token', '=', $token)->first();
        if(!$mapEntry) {
            throw new NotFoundException();
        }

        return $mapEntry;
    }

    public function save(MapEntry $mapEntry)
    {
        if (!$mapEntry->save()) {
            throw new NotSavedException();
        }
    }
}
