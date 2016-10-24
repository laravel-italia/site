<?php

namespace LaravelItalia\Notifications\Destinations;

use Config;
use Illuminate\Notifications\Notifiable;

class AllTodayArticlesOnSlack
{
    use Notifiable;

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return Config::get('notifications.all_daily_articles.hook_url');
    }
}
