<?php

namespace LaravelItalia\Notifications;

use Config;
use Illuminate\Notifications\Notification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Messages\SlackAttachment;

class AllTodayArticlesToSlack extends Notification
{
    private $allTodayArticles;

    public function __construct(Collection $allTodayArticles)
    {
        $this->allTodayArticles = $allTodayArticles;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $slackMessage = (new SlackMessage())
            ->to('@' . Config::get('notifications.all_daily_articles.username'))
            ->content('Ehi, ciao! Ecco quali sono gli articoli previsti per oggi!');

        foreach($this->allTodayArticles as $article) {
            $slackMessage->attachment(function (SlackAttachment $attachment) use ($article) {
                $title = '- Alle ' . date('H:i', strtotime($article->published_at)) . ': ' . $article->title;

                $attachment
                    ->title($title, url('articoli/' . $article->slug))
                    ->content($article->digest);
            });
        }

        return $slackMessage;
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
