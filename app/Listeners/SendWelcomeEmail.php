<?php

namespace LaravelItalia\Listeners;

use Mail;
use LaravelItalia\Events\UserHasSignedUp;

class SendWelcomeEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param UserHasSignedUp $event
     */
    public function handle(UserHasSignedUp $event)
    {
        $user = $event->getUser();

        if (is_null($user->getAuthenticationProvider())) {
            Mail::send('emails.user_welcome', ['user' => $user], function ($m) use ($user) {
                $m->to($user->email, $user->name)
                    ->subject('Benvenuto! :: Laravel-Italia.it')
                ;
            });
        }
    }
}
