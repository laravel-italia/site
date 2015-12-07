<?php

namespace LaravelItalia\Entities\Repositories;


use LaravelItalia\Entities\Article;
use LaravelItalia\Entities\Category;
use LaravelItalia\Entities\User;
use \Config;

/**
 * Class ArticleRepository
 * @package LaravelItalia\Entities\Repositories
 */
class ArticleRepository
{
    public function getAll($page, $onlyPublished = false)
    {
        $query = Article::with(['user', 'categories']);

        if($onlyPublished)
            $query->published();

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

        if($onlyPublished)
            $query->published();

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

        if($onlyPublished)
            $query->published();

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

        if($onlyPublished)
            $query->published();

        return $query->where('slug', '=', $slug)->first();
    }

    public function findById($id, $onlyPublished = false)
    {
        $query = Article::with(['user', 'categories']);

        if($onlyPublished)
            $query->published();

        return $query->find($id);
    }

    public function save(Article $article)
    {
        $article->save();
    }

    public function delete(Article $article)
    {
        $article->delete();
    }
}