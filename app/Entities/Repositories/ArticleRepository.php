<?php

namespace LaravelItalia\Entities\Repositories;

use Config;
use LaravelItalia\Entities\User;
use LaravelItalia\Entities\Article;
use LaravelItalia\Entities\Category;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;


/**
 * Class ArticleRepository
 * @package LaravelItalia\Entities\Repositories
 */
class ArticleRepository
{
    /**
     * @param $page
     * @param bool|false $onlyPublished
     * @return mixed
     */
    public function getAll($page, $onlyPublished = false)
    {
        $query = Article::with(['user', 'categories', 'series'])->orderBy('published_at', 'desc');

        if ($onlyPublished) {
            $query->published();
        }

        return $query->paginate(
                Config::get('publications.articles_per_page'),
                ['*'],
                'page',
                $page
        );
    }

    /**
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
     * @param $id
     * @param bool|false $onlyPublished
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     * @throws NotFoundException
     */
    public function findById($id, $onlyPublished = false)
    {
        $query = Article::with(['user', 'categories']);

        if ($onlyPublished) {
            $query->published();
        }

        $result = $query->find($id);

        if (!$result) {
            throw new NotFoundException();
        }

        return $result;
    }

    /**
     * @param $slug
     * @param bool|false $onlyPublished
     * @return \Illuminate\Database\Eloquent\Model|null|static
     * @throws NotFoundException
     */
    public function findBySlug($slug, $onlyPublished = false)
    {
        $query = Article::with(['user', 'categories']);

        if ($onlyPublished) {
            $query->published();
        }

        $result = $query->where('slug', '=', $slug)->first();

        if (!$result) {
            throw new NotFoundException();
        }

        return $result;
    }

    /**
     * @param Category $category
     * @param $page
     * @param bool|false $onlyPublished
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByCategory(Category $category, $page, $onlyPublished = false)
    {
        $query = $category->articles()->getQuery()->with(['user', 'categories', 'series']);

        if ($onlyPublished) {
            $query->published();
        }

        return $query->paginate(
            Config::get('publications.articles_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    /**
     * @param User $user
     * @param $page
     * @param bool|false $onlyPublished
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function findByUser(User $user, $page, $onlyPublished = false)
    {
        $query = $user->articles()->getQuery()->with(['user', 'categories', 'series']);

        if ($onlyPublished) {
            $query->published();
        }

        return $query->paginate(
            Config::get('publications.articles_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    /**
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
