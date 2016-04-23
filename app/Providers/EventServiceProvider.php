<?php

namespace LaravelItalia\Providers;

use LaravelItalia\Domain\Article;
use LaravelItalia\Domain\Category;
use LaravelItalia\Domain\Media;
use LaravelItalia\Domain\Observers\DeleteRepliesWhenDeletingThread;
use LaravelItalia\Domain\Observers\DeleteThreadsWithoutAssociatedTags;
use LaravelItalia\Domain\Observers\RemoveArticlesWhenDeletingSeries;
use LaravelItalia\Domain\Observers\RemoveFileWhenDeletingMedia;
use LaravelItalia\Domain\Observers\UploadFileWhenAddingMedia;
use LaravelItalia\Domain\Series;
use LaravelItalia\Domain\Observers\DetachArticlesWhenDeletingCategory;
use LaravelItalia\Domain\Observers\DetachCategoriesBeforeArticleDelete;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelItalia\Domain\Tag;
use LaravelItalia\Domain\Thread;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'LaravelItalia\Events\UserHasSignedUp' => [
            'LaravelItalia\Listeners\SendWelcomeEmail',
        ],

        'LaravelItalia\Events\UserHasRecoveredPassword' => [
            'LaravelItalia\Listeners\SendRecoveryEmail',
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @param \Illuminate\Contracts\Events\Dispatcher $events
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        Article::observe(DetachCategoriesBeforeArticleDelete::class);

        Media::observe(UploadFileWhenAddingMedia::class);
        Media::observe(RemoveFileWhenDeletingMedia::class);

        Series::observe(RemoveArticlesWhenDeletingSeries::class);

        Category::observe(DetachArticlesWhenDeletingCategory::class);

        Tag::observe(DeleteThreadsWithoutAssociatedTags::class);

        Thread::observe(DeleteRepliesWhenDeletingThread::class);
    }
}
