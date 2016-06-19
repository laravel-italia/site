<?php

namespace LaravelItalia\Listeners;

use Mail;
use Illuminate\Mail\Message;
use LaravelItalia\Events\EditorHasBeenInvited;


/**
 * Si occupa di inviare la mail contenente l'invito ad un nuovo editor.
 *
 * Class SendEditorInvitationEmail
 * @package LaravelItalia\Listeners
 */
class SendEditorInvitationEmail
{
    public function handle(EditorHasBeenInvited $event)
    {
        $user = $event->getUser();

        Mail::send('emails.editor_invite', ['user' => $user], function (Message $m) use ($user) {
            $m->to($user->email, $user->name)
                ->subject('Invito Editor :: Laravel-Italia.it')
            ;
        });
    }
}
