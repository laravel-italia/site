<?php

namespace LaravelItalia\Entities\Factories;

use LaravelItalia\Entities\Media;

/**
 * Class MediaFactory.
 */
class MediaFactory
{
    /**
     * @return Media
     */
    public static function createMedia()
    {
        return new Media();
    }
}
