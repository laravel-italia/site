<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Series;
use LaravelItalia\Exceptions\NotFoundException;

class SeriesRepository
{
    /**
     * Restituisce tutte le serie salvate, o solo quelle pubblicate se $onlyPublished è true.
     *
     * @param bool $onlyPublished
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
     * Restituisce la serie il cui id è $id.
     *
     * @param $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws NotFoundException
     */
    public function findByid($id)
    {
        $series = Series::with('articles')->find($id);

        if(!$series) {
            throw new NotFoundException;
        }

        return $series;
    }

    /**
     * Restituisce la serie il cui slug è $slug. Se $onlyPublished è true, allora la serie verrà restituita solo se
     * marcata come pubblicata.
     *
     * @param $slug
     * @param bool $onlyPublished
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws NotFoundException
     */
    public function findBySlug($slug, $onlyPublished = false)
    {
        $query = Series::with('articles');

        if ($onlyPublished) {
            $query->published();
        }

        $series = $query->where('slug', '=', $slug)->first();

        if(!$series) {
            throw new NotFoundException;
        }

        return $series;
    }

    /**
     * Salva su database la serie $series passata.
     *
     * @param Series $series
     */
    public function save(Series $series)
    {
        $series->save();
    }

    /**
     * Rimuove dal database la serie $series passata.
     *
     * @param Series $series
     * @throws \Exception
     */
    public function delete(Series $series)
    {
        $series->delete();
    }
}
