<?php

namespace LaravelItalia\Domain\Repositories;

use Carbon\Carbon;
use Config;
use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Domain\Series;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

class ArticleRepository
{
    /**
     * Restituisce, paginati, gli articoli presenti sul database. Se $onlyPublished è true, solo quelli
     * mandati in pubblicazione. Se $onlyVisible è true, solo quelli già pubblicati e già visibili.
     *
     * @param $page
     * @param bool $onlyPublished
     * @param bool $onlyVisible
     * @return mixed
     */
    public function getAll($page, $onlyPublished = false, $onlyVisible = false)
    {
        $query = Article::with(['user', 'categories', 'series'])->orderBy('published_at', 'desc');

        if ($onlyPublished) {
            $query->published();
        }

        if ($onlyVisible) {
            $query->visible();
        }

        return $query->paginate(
                Config::get('settings.publications.articles_per_page'),
                ['*'],
                'page',
                $page
        );
    }

    /**
     * Restituisce l'insieme degli articoli non ancora pubblicati, e quindi da controllare.
     *
     * @return mixed
     */
    public function getUnpublished()
    {
        return Article::with(['user', 'categories'])
            ->where('published_at', '=', null)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * Restituisce, paginati, gli articoli presenti sul database appartenenti alla categoria $category.
     * Se $onlyPublished è true, solo quelli mandati in pubblicazione. Se $onlyVisible è true, solo quelli
     * già pubblicati e già visibili.
     *
     * @param Category $category
     * @param $page
     * @param bool $onlyPublished
     * @param bool $onlyVisible
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getByCategory(Category $category, $page, $onlyPublished = false, $onlyVisible = false)
    {
        $query = $category->articles()->getQuery()->with(['user', 'categories', 'series'])->orderBy('published_at', 'desc');

        if ($onlyPublished) {
            $query->published();
        }

        if ($onlyVisible) {
            $query->visible();
        }

        return $query->paginate(
            Config::get('publications.articles_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    /**
     * Restituisce una collection contenente gli articoli in pubblicazione nella giornata odierna. Se il parametro
     * $alreadyPublishedOnly è true, restituisce solo gli articoli pubblicati da mezzanotte ad ora.
     *
     * @param $alreadyPublishedOnly
     *
     * @return mixed
     */
    public function getTodayArticles($alreadyPublishedOnly = true)
    {
        $endDate = ($alreadyPublishedOnly) ? Carbon::now() : Carbon::today()->addDay(1);

        return Article::whereBetween('published_at', [Carbon::today(), $endDate])
            ->published()
            ->orderBy('published_at', 'desc')
            ->get();
    }

    /**
     * Restituisce un articolo a partire dal suo id.
     *
     * @param $id
     * @return Collection|Model|null
     * @throws NotFoundException
     */
    public function findById($id)
    {
        $result = Article::with(['user', 'categories'])->find($id);

        if (!$result) {
            throw new NotFoundException();
        }

        return $result;
    }

    /**
     * Restituisce un articolo a partire dal suo slug. Se $onlyPublished è true, solo se mandato in pubblicazione.
     * Se $onlyVisible è true, solo se già pubblicato e visibile.
     *
     * @param $slug
     * @param bool $onlyPublished
     * @param bool $onlyVisible
     * @return Model|null|static
     * @throws NotFoundException
     */
    public function findBySlug($slug, $onlyPublished = false, $onlyVisible = false)
    {
        $query = Article::with(['user', 'categories', 'series']);

        if ($onlyPublished) {
            $query->published();
        }

        if ($onlyVisible) {
            $query->visible();
        }

        $result = $query->where('slug', '=', $slug)->first();

        if (!$result) {
            throw new NotFoundException();
        }

        return $result;
    }


    /**
     * Restituisce un articolo a partire dal suo slug e dalla sua appartenenza alla serie $series. Se $onlyPublished è
     * true, solo se mandato in pubblicazione. Se $onlyVisible è true, solo se già pubblicato e visibile.
     *
     * @param Series $series
     * @param $slug
     * @param bool $onlyPublished
     * @param bool $onlyVisible
     * @return mixed
     * @throws NotFoundException
     */
    public function findBySeriesAndSlug(Series $series, $slug, $onlyPublished = false, $onlyVisible = false)
    {
        $query = $series->articles()->with(['user', 'categories', 'series']);

        if ($onlyPublished) {
            $query->published();
        }

        if ($onlyVisible) {
            $query->visible();
        }

        $result = $query->where('slug', '=', $slug)->first();

        if (!$result) {
            throw new NotFoundException();
        }

        return $result;
    }

    /**
     * Salva l'articolo $article sul datbase.
     *
     * @param Article $article
     * @throws NotSavedException
     */
    public function save(Article $article)
    {
        if (!$article->save()) {
            throw new NotSavedException();
        }
    }

    /**
     * Cancella dal database l'articolo $article.
     *
     * @param Article $article
     * @throws NotDeletedException
     * @throws \Exception
     */
    public function delete(Article $article)
    {
        if (!$article->delete()) {
            throw new NotDeletedException();
        }
    }
}
