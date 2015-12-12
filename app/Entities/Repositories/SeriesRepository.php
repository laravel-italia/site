<?php

namespace LaravelItalia\Entities\Repositories;

use LaravelItalia\Entities\Series;

/**
 * Class SeriesRepository.
 */
class SeriesRepository
{
    public function save(Series $series)
    {
        $series->save();
    }

    public function findBySlug($slug, $onlyPublished = false)
    {
        $query = Series::with('articles');

        if ($onlyPublished) {
            $query->published();
        }

        return $query->where('slug', '=', $slug)->first();
    }

    public function findByid($id, $onlyPublished = false)
    {
        $query = Series::with('articles');

        if ($onlyPublished) {
            $query->published();
        }

        return $query->find($id);
    }

    public function getAll($onlyPublished = false)
    {
        $query = Series::with('articles');

        if ($onlyPublished) {
            $query->published();
        }

        return $query->get();
    }

    public function delete(Series $series)
    {
        $series->delete();
    }
}
