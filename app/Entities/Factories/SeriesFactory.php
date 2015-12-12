<?php

namespace LaravelItalia\Entities\Factories;

use Illuminate\Support\Str;
use LaravelItalia\Entities\Series;

/**
 * Class SeriesFactory.
 */
class SeriesFactory
{
    /**
     * @param $title
     * @param $description
     * @param $metadescription
     * @param $isPublished
     * @param $isCompleted
     *
     * @return Series
     */
    public static function createSeries($title, $description, $metadescription, $isPublished, $isCompleted)
    {
        $series = new Series();

        $series->title = $title;
        $series->description = $description;
        $series->metadescription = $metadescription;
        $series->is_published = $isPublished;
        $series->is_completed = $isCompleted;

        $series->slug = Str::slug($series->title);

        return $series;
    }
}
