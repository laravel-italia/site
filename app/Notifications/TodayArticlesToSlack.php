<?php

namespace LaravelItalia\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Notifications\Messages\SlackAttachment;
use Illuminate\Notifications\Messages\SlackMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TodayArticlesToSlack extends Notification
{
    /* @var Collection $todayArticles */
    private $todayArticles;

    public function __construct(Collection $todayArticles)
    {
        $this->todayArticles = $todayArticles;
    }

    public function via($notifiable)
    {
        return ['slack'];
    }

    public function toSlack($notifiable)
    {
        $slackMessage = (new SlackMessage())
            ->to('#general')
            ->content('Ehi, gente! Prima di andare in pausa pranzo, ecco cosa è stato pubblicato oggi sul sito!');

        foreach($this->todayArticles as $article) {
            $slackMessage->attachment(function (SlackAttachment $attachment) use ($article) {
                $attachment
                    ->title($article->title, url('articoli/' . $article->slug))
                    ->content($article->digest);
            });
        }

        return $slackMessage;
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
