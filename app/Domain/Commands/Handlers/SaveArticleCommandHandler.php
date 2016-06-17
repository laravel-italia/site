<?php

namespace LaravelItalia\Domain\Commands\Handlers;


use LaravelItalia\Domain\Commands\SaveArticleCommand;
use LaravelItalia\Domain\Repositories\ArticleRepository;

class SaveArticleCommandHandler
{
    private $articleRepository;

    /**
     * SaveArticleCommandHandler constructor.
     * @param ArticleRepository $articleRepository
     */
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