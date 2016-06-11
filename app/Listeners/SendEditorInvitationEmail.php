<?php

namespace LaravelItalia\Listeners;

use Mail;
use Illuminate\Mail\Message;
use LaravelItalia\Events\EditorHasBeenInvited;

class SendEditorInvitationEmail
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
     * @param EditorHasBeenInvited $event
     */
    public function handle(EditorHasBeenInvited $event)
    {
        $user = $event->getUser();

        if (is_null($user->getAuthenticationProvider())) {
            Mail::send('emails.editor_invite', ['user' => $user], function (Message $m) use ($user) {
                $m->to($user->email, $user->name)
                    ->subject('Invito Editor :: Laravel-Italia.it')
                ;
            });
        }
    }
}
