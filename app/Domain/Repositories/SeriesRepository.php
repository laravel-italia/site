<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Series;

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
     * Restituisce una serie partendo dal suo id. Se $onlyPublished è true la restituisce solo
     * se è stata già pubblicata.
     *
     * @param $id
     * @param bool $onlyPublished
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
     * Restituisce una serie dato il suo slug. Se $onlyPublished è true, la restituisce solo se
     * già pubblicata.
     *
     * @param $slug
     * @param bool $onlyPublished
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
