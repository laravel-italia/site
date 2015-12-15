<?php

namespace LaravelItalia\Entities\Repositories;

use LaravelItalia\Entities\Article;
use LaravelItalia\Entities\Category;
use LaravelItalia\Entities\User;
use Config;
use LaravelItalia\Exceptions\NotDeletedException;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Exceptions\NotSavedException;

/**
 * Class ArticleRepository.
 */
class ArticleRepository
{
    public function getAll($page, $onlyPublished = false)
    {
        $query = Article::with(['user', 'categories']);

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

    public function findByCategory(Category $category, $page, $onlyPublished = false)
    {
        $query = $category->articles()->getQuery()->with(['user', 'categories']);

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

    public function findByUser(User $user, $page, $onlyPublished = false)
    {
        $query = $user->articles()->getQuery()->with(['user', 'categories']);

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

    public function save(Article $article)
    {
        if (!$article->save()) {
            throw new NotSavedException();
        }
    }

    public function delete(Article $article)
    {
        if (!$article->delete()) {
            throw new NotDeletedException();
        }
    }
}
