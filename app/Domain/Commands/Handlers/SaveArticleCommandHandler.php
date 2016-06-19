<?php

namespace LaravelItalia\Domain\Commands\Handlers;


use LaravelItalia\Domain\Commands\SaveArticleCommand;
use LaravelItalia\Domain\Repositories\ArticleRepository;

/**
 * Effettua il salvataggio di un articolo e le relative operazioni di associazione a categorie, utente ed
 * eventuale serie.
 *
 * Class SaveArticleCommandHandler
 * @package LaravelItalia\Domain\Commands\Handlers
 */
class SaveArticleCommandHandler
{
    private $articleRepository;

    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function handle(SaveArticleCommand $command)
    {
        $article = $command->getArticle();
        $article->setUser($command->getUser());
        $article->setSeries($command->getSeries());

        $this->articleRepository->save($article);

        $article->syncCategories($command->getCategories());
    }
}