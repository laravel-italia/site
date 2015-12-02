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
    /**
     * @param $page int
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAll($page)
    {
        return Article::with(['user', 'categories'])
            ->paginate(
                Config::get('publications.articles_per_page'),
                ['*'],
                'page',
                $page
            );
    }

    public function findByCategory(Category $category, $page)
    {
        $category->articles()
            ->getQuery()
            ->with(['user', 'categories'])
            ->paginate(
                Config::get('publications.articles_per_page'),
                ['*'],
                'page',
                $page
            );
    }

    public function findByUser(User $user, $page)
    {
        $user->articles()
            ->getQuery()
            ->with(['user', 'categories'])
            ->paginate(
                Config::get('publications.articles_per_page'),
                ['*'],
                'page',
                $page
            );
    }

    public function findBySlug($slug)
    {
        return Article::with(['user', 'categories'])->where('slug', '=', $slug)->first();
    }

    public function findById($id)
    {
        return Article::find($id);
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