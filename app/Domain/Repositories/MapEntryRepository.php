<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\MapEntry;
use LaravelItalia\Exceptions\NotSavedException;

class MapEntryRepository
{
    public function save(MapEntry $mapEntry)
    {
        if (!$mapEntry->save()) {
            throw new NotSavedException();
        }
    }
}
