<?php

namespace LaravelItalia\Entities\Repositories;

use LaravelItalia\Entities\Series;

/**
 * Class SeriesRepository
 * @package LaravelItalia\Entities\Repositories
 */
class SeriesRepository
{
    /**
     * @param bool|false $onlyPublished
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function getAll($onlyPublished = false)
    {
        $query = Series::with('articles');

        if ($onlyPublished) {
            $query->published();
        }

        return $query->get();
    }

    /**
     * @param $id
     * @param bool|false $onlyPublished
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function findByid($id, $onlyPublished = false)
    {
        $query = Series::with('articles');

        if ($onlyPublished) {
            $query->published();
        }

        return $query->find($id);
    }

    /**
     * @param $slug
     * @param bool|false $onlyPublished
     * @return \Illuminate\Database\Eloquent\Model|null|static
     */
    public function findBySlug($slug, $onlyPublished = false)
    {
        $query = Series::with('articles');

        if ($onlyPublished) {
            $query->published();
        }

        return $query->where('slug', '=', $slug)->first();
    }

    /**
     * @param Series $series
     */
    public function save(Series $series)
    {
        $series->save();
    }

    /**
     * @param Series $series
     * @throws \Exception
     */
    public function delete(Series $series)
    {
        $series->delete();
    }
}
