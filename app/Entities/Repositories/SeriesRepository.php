<?php

namespace LaravelItalia\Entities\Repositories;


use LaravelItalia\Entities\Series;

/**
 * Class SeriesRepository
 * @package LaravelItalia\Entities\Repositories
 */
class SeriesRepository
{
    public function save(Series $series)
    {
        $series->save();
    }

    public function findBySlug($slug)
    {
        return Series::where('slug', '=', $slug)->first();
    }

    public function findByid($id)
    {
        return Series::find($id);
    }

    public function getAll()
    {
        return Series::all();
    }

    public function delete(Series $series)
    {
        $series->delete();
    }
}