<?php

namespace LaravelItalia\Console\Commands;

use Notification;
use Illuminate\Console\Command;
use LaravelItalia\Notifications\TodayArticlesToSlack;
use LaravelItalia\Domain\Repositories\ArticleRepository;
use LaravelItalia\Notifications\Destinations\TodayArticlesOnSlack;

class SendTodayArticlesToSlack extends Command
{
    /* @var ArticleRepository */
    private $articleRepository;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'slack:send-today-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manda su Slack (#general) gli articoli pubblicati da mezzanotte ad ora.';

    /**
     * Create a new command instance.
     *
     * @param ArticleRepository $articleRepository
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
        $todayArticles = $this->articleRepository->getTodayArticles();

        if(count($todayArticles) > 0) {
            $this->output->writeln('Sending...');
            try {
                Notification::send([new TodayArticlesOnSlack()], new TodayArticlesToSlack($todayArticles));
                $this->output->writeln('Done!');
            } catch (\Exception $e) {
                $this->output->writeln($e->getMessage());
            }
        } else {
            $this->output->writeln('No articles found :(');
        }
    }
}
