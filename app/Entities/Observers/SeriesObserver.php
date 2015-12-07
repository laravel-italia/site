<?php

namespace LaravelItalia\Entities\Observers;


use LaravelItalia\Entities\Series;

class SeriesObserver
{

    public function deleting(Series $series)
    {
        $articles = $series->articles()->get();

        foreach($articles as $article){
            $article->delete();
        }
    }
}