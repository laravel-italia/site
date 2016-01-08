<?php

namespace LaravelItalia\Providers;

use LaravelItalia\Entities\Article;
use LaravelItalia\Entities\Category;
use LaravelItalia\Entities\Media;
use LaravelItalia\Entities\Observers\DeleteRepliesWhenDeletingThread;
use LaravelItalia\Entities\Observers\DeleteThreadsWithoutAssociatedTags;
use LaravelItalia\Entities\Observers\RemoveArticlesWhenDeletingSeries;
use LaravelItalia\Entities\Observers\RemoveFileWhenDeletingMedia;
use LaravelItalia\Entities\Observers\UploadFileWhenAddingMedia;
use LaravelItalia\Entities\Series;
use LaravelItalia\Entities\Observers\DetachArticlesWhenDeletingCategory;
use LaravelItalia\Entities\Observers\DetachCategoriesBeforeArticleDelete;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelItalia\Entities\Tag;
use LaravelItalia\Entities\Thread;

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
