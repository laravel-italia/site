<?php

namespace LaravelItalia\Domain\Commands;


use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Article;
use Illuminate\Database\Eloquent\Collection;

/**
 * Salva un articolo (sia nuovo che esistente) assegnando ad esso il giusto utente, categorie ed eventuale serie.
 *
 * Class SaveArticleCommand
 * @package LaravelItalia\Domain\Commands
 */
class SaveArticleCommand
{
    private $article;
    private $user;
    private $categories;
    private $series;

    public function __construct(Article $article, User $user, Collection $categories, $series)
    {
        $this->article = $article;
        $this->user = $user;
        $this->categories = $categories;
        $this->series = $series;
    }

    public function getArticle()
    {
        return $this->article;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getCategories()
    {
        return $this->categories;
    }

    public function getSeries()
    {
        return $this->series;
    }
}