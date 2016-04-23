<?php

namespace LaravelItalia\Domain\Factories;

use LaravelItalia\Domain\Media;

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
