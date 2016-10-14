<?php

namespace LaravelItalia\Notifications\Destinations;

use Config;
use Illuminate\Notifications\Notifiable;

class TodayArticlesOnSlack
{
    use Notifiable;

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return Config::get('notifications.daily_articles.hook_url');
    }
}
