<?php

namespace LaravelItalia\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use LaravelItalia\Domain\Commands\AssignRoleToUserCommand;
use LaravelItalia\Domain\Repositories\RoleRepository;
use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Series;
use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Category;
use Illuminate\Database\Eloquent\Collection;
use LaravelItalia\Exceptions\NotFoundException;
use LaravelItalia\Domain\Commands\SaveArticleCommand;
use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\Repositories\SeriesRepository;
use JildertMiedema\LaravelTactician\DispatchesCommands;
use LaravelItalia\Domain\Repositories\CategoryRepository;

class ImportOldSiteData extends Command
{
    use DispatchesCommands;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:old-data {path=export_data.json : the path of export data .json file}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports data from the old site using a .json file specified as argument (or export_data.json as default).';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $filePath = $this->argument('path');
        $exportData = json_decode(file_get_contents($filePath), true);

        foreach($exportData as $singleArticle) {
            $user = $this->findOrCreateUserFor($singleArticle);
            $series = $this->findOrCreateSeriesFor($singleArticle);
            $categories = $this->findOrCreateCategoriesFor($singleArticle);

            $article = Article::createFromData(
                $singleArticle['title'],
                $singleArticle['digest'],
                $singleArticle['body'],
                $singleArticle['metadescription']
            );

            $article->publish(new Carbon($singleArticle['published_at']));

            $this->dispatch(new SaveArticleCommand(
                $article,
                $user,
                $categories,
                $series
            ));
        }

        $this->info('Import procedure completed.');
    }

    private function findOrCreateUserFor($article)
    {
        /* @var UserRepository $userRepository */
        $userRepository = app(UserRepository::class);

        /* @var RoleRepository $roleRepository */
        $roleRepository = app(RoleRepository::class);
        $adminRole = $roleRepository->findByName('administrator');

        try {
            $user = $userRepository->findByEmail($article['user']['email']);
        } catch (NotFoundException $e) {
            $user = User::fromNameAndEmailAndPassword(
                $article['user']['first_name'] . ' ' . $article['user']['last_name'],
                $article['user']['email'],
                'secret'
            );

            $user->is_confirmed = true;

            $this->dispatch(new AssignRoleToUserCommand(
                $adminRole,
                $user
            ));

            $userRepository->save($user);
        }

        return $user;
    }

    private function findOrCreateSeriesFor($article)
    {
        // yes, I used the shitty name "serie" to play with the Eloquent singular/plural
        if(intval($article['serie_id']) === 0) {
            return null;
        }

        /* @var SeriesRepository $seriesRepository */
        $seriesRepository = app(SeriesRepository::class);

        try {
            $series = $seriesRepository->findBySlug($article['serie']['slug']);
        } catch (NotFoundException $e) {
            $series = Series::createFromTitleAndDescriptionAndMetaDescription(
                $article['serie']['title'],
                $article['serie']['description'],
                $article['serie']['metadescription']
            );

            $series->is_published = boolval($article['serie']['is_visible']);
            $series->is_completed = boolval($article['serie']['is_finished']);

            $seriesRepository->save($series);
        }

        return $series;
    }

    private function findOrCreateCategoriesFor($article)
    {
        $categories = new Collection();

        /* @var CategoryRepository $categoryRepository */
        $categoryRepository = app(CategoryRepository::class);

        foreach($article['categories'] as $oldCategory) {
            try {
                $category = $categoryRepository->findBySlug($oldCategory['slug']);
            } catch (NotFoundException $e) {
                $category = Category::createFromName($oldCategory['name']);
                $categoryRepository->save($category);
            }

            $categories->add($category);
        }

        return $categories;
    }
}
