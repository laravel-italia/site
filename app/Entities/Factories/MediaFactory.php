<?php

namespace LaravelItalia\Entities\Factories;

use LaravelItalia\Entities\Media;

/**
 * Class MediaFactory
 * @package LaravelItalia\Entities\Factories
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
