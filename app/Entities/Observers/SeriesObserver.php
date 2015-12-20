<?php

namespace LaravelItalia\Entities\Observers;

use LaravelItalia\Entities\Series;

/**
 * Class SeriesObserver.
 */
class SeriesObserver
{
    /**
     * @param Series $series
     */
    public function deleting(Series $series)
    {
        $articles = $series->articles()->get();

        foreach ($articles as $article) {
            $article->delete();
        }
    }
}
