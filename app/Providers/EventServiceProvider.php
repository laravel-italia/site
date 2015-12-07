<?php

namespace LaravelItalia\Providers;

use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use LaravelItalia\Entities\Media;
use LaravelItalia\Entities\Observers\MediaUploader;

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
     * @param  \Illuminate\Contracts\Events\Dispatcher  $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        Media::observe(MediaUploader::class);
    }
}
