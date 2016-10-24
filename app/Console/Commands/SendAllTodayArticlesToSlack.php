<?php

namespace LaravelItalia\Console\Commands;

use Notification;
use Illuminate\Console\Command;
use LaravelItalia\Domain\Repositories\ArticleRepository;
use LaravelItalia\Notifications\AllTodayArticlesToSlack;
use LaravelItalia\Notifications\Destinations\AllTodayArticlesOnSlack;

class SendAllTodayArticlesToSlack extends Command
{
    /* @var ArticleRepository $articleRepository */
    private $articleRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slack:send-all-today-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manda su Slack (utente specifico) gli articoli in pubblicazione oggi.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(ArticleRepository $articleRepository)
    {
        parent::__construct();

        $this->articleRepository = $articleRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $allTodayArticles = $this->articleRepository->getTodayArticles(false);

        if(count($allTodayArticles) > 0) {
            $this->output->writeln('Sending...');
            try {
                Notification::send([new AllTodayArticlesOnSlack()], new AllTodayArticlesToSlack($allTodayArticles));
                $this->output->writeln('Done!');
            } catch (\Exception $e) {
                $this->output->writeln($e->getMessage());
            }
        } else {
            $this->output->writeln('No articles found :(');
        }
    }
}
