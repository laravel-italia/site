<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\MapEntry;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;

class MapEntryRepository
{
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
