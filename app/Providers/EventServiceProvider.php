<?php

namespace LaravelItalia\Providers;

use LaravelItalia\Entities\Article;
use LaravelItalia\Entities\Media;
use LaravelItalia\Entities\Observers\MediaObserver;
use LaravelItalia\Entities\Series;
use LaravelItalia\Entities\Observers\SeriesObserver;
use LaravelItalia\Entities\Observers\ArticleObserver;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

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

        Media::observe(MediaObserver::class);
        Series::observe(SeriesObserver::class);
        Article::observe(ArticleObserver::class);
    }
}
