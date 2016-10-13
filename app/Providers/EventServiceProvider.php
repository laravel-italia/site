<?php

namespace LaravelItalia\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Category;
use LaravelItalia\Domain\Media;
use LaravelItalia\Domain\Observers\DetachArticlesWhenDeletingCategory;
use LaravelItalia\Domain\Observers\DetachCategoriesBeforeArticleDelete;
use LaravelItalia\Domain\Observers\RemoveArticlesWhenDeletingSeries;
use LaravelItalia\Domain\Observers\RemoveFileWhenDeletingMedia;
use LaravelItalia\Domain\Observers\UploadFileWhenAddingMedia;
use LaravelItalia\Domain\Series;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'LaravelItalia\Events\UserHasRecoveredPassword' => [
            'LaravelItalia\Listeners\SendPasswordRecoveryEmail',
        ],

        'LaravelItalia\Events\EditorHasBeenInvited' => [
            'LaravelItalia\Listeners\SendEditorInvitationEmail'
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Article::observe(DetachCategoriesBeforeArticleDelete::class);

        Media::observe(UploadFileWhenAddingMedia::class);
        Media::observe(RemoveFileWhenDeletingMedia::class);

        Series::observe(RemoveArticlesWhenDeletingSeries::class);

        Category::observe(DetachArticlesWhenDeletingCategory::class);
    }
}
