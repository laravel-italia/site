<?php

namespace LaravelItalia\Domain\Observers;

use LaravelItalia\Domain\Series;

/**
 * Rimuove tutti gli articoli di una serie che sta per essere cancellata.
 *
 * Class RemoveArticlesWhenDeletingSeries
 * @package LaravelItalia\Domain\Observers
 */
class RemoveArticlesWhenDeletingSeries
{
    public function deleting(Series $series)
    {
        $articles = $series->articles()->get();

        foreach ($articles as $article) {
            $article->delete();
        }
    }
}
