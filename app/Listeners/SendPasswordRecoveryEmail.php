<?php

namespace LaravelItalia\Listeners;

use Mail;
use Illuminate\Mail\Message;
use LaravelItalia\Events\UserHasRecoveredPassword;


/**
 * Si occupa di inviare la mail per il recupero delle credenziali.
 *
 * Class SendPasswordRecoveryEmail
 * @package LaravelItalia\Listeners
 */
class SendPasswordRecoveryEmail
{
    public function handle(UserHasRecoveredPassword $event)
    {
        $user = $event->getUser();

        $token = $event->getToken();

        Mail::send('emails.user_password_recovery', ['user' => $user, 'token' => $token], function (Message $m) use ($user) {
            $m->to($user->email, $user->name)
                ->subject('Scelta Nuova Password :: Laravel-Italia.it')
            ;
        });
    }
}
