<?php

namespace LaravelItalia\Domain\Repositories;

use Config;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Category;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;
use LaravelItalia\Exceptions\NotDeletedException;

/**
 * Class ArticleRepository.
 */
class ArticleRepository
{
    /**
     * @param $page
     * @param bool|false $onlyPublished
     * @param bool|false $onlyVisible
     *
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
     * @return Collection|static[]
     */
    public function getUnpublished()
    {
        return Article::with(['user', 'categories'])
            ->where('published_at', '=', null)
            ->orderBy('created_at', 'asc')
            ->get();
    }

    /**
     * @param Category $category
     * @param $page
     * @param bool|false $onlyPublished
     * @param bool|false $onlyVisible
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getByCategory(Category $category, $page, $onlyPublished = false, $onlyVisible = false)
    {
        $query = $category->articles()->getQuery()->with(['user', 'categories', 'series']);

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
     * @param User $user
     * @param $page
     * @param bool|false $onlyPublished
     * @param bool|false $onlyVisible
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getByUser(User $user, $page, $onlyPublished = false, $onlyVisible = false)
    {
        $query = $user->articles()->getQuery()->with(['user', 'categories', 'series']);

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
     * @param $id
     * @param bool|false $onlyPublished
     *
     * @return Article|null
     *
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
     *
     * @return Article|null
     *
     * @throws NotFoundException
     */
    public function findBySlug($slug, $onlyPublished = false, $onlyVisible = false)
    {
        $query = Article::with(['user', 'categories']);

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
     * @param Article $article
     *
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
     *
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
