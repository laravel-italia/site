<?php

namespace LaravelItalia\Domain\Commands;


use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Series;
use LaravelItalia\Domain\User;

class SaveArticleCommand
{
    private $article;
    private $user;
    private $categories;
    private $series;

    /**
     * SaveArticleCommand constructor.
     * @param $article
     * @param $user
     * @param $categories
     * @param null|Series $series
     */
    public function __construct(Article $article, User $user, Collection $categories, $series)
    {
        $this->article = $article;
        $this->user = $user;
        $this->categories = $categories;
        $this->series = $series;
    }

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return Collection
     */
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * @return Series
     */
    public function getSeries()
    {
        return $this->series;
    }
}