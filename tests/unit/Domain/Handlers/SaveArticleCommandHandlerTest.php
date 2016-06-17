<?php

use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Series;
use LaravelItalia\Domain\Article;
use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Domain\Commands\SaveArticleCommand;
use LaravelItalia\Domain\Repositories\ArticleRepository;
use LaravelItalia\Domain\Commands\Handlers\SaveArticleCommandHandler;

class SaveArticleCommandHandlerTest extends TestCase
{
    private $article;
    private $user;
    private $categories;

    /**
     * @var SaveArticleCommandHandler
     */
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->article = Mockery::mock(Article::class);
        $this->user = Mockery::mock(User::class);
        $this->categories = Mockery::mock(Collection::class);

        $this->article->shouldReceive('setUser')->times(1);
        $this->article->shouldReceive('syncCategories')->times(1);

        $articleRepo = Mockery::mock(ArticleRepository::class);
        $articleRepo->shouldReceive('save')->times(1);

        $this->handler = new SaveArticleCommandHandler(
            $articleRepo
        );
    }

    public function testHandleWithoutSeries()
    {
        $this->article->shouldReceive('setSeries')->times(1);

        $this->handler->handle(
            new SaveArticleCommand(
                $this->article,
                $this->user,
                $this->categories,
                null
            )
        );
    }

    public function testHandleWithSeries()
    {
        $this->article->shouldReceive('setSeries')->times(1);

        $series = Mockery::mock(Series::class);

        $this->handler->handle(
            new SaveArticleCommand(
                $this->article,
                $this->user,
                $this->categories,
                $series
            )
        );
    }
}