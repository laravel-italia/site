<?php

namespace LaravelItalia\Listeners;

use \Mail;
use LaravelItalia\Events\UserHasRecoveredPassword;

class SendPasswordRecoveryEmail
{
    /**
     * Handle the event.
     *
     * @param  UserHasRecoveredPassword  $event
     * @return void
     */
    public function handle(UserHasRecoveredPassword $event)
    {
        $user = $event->getUser();

        if(is_null($user->getAuthenticationProvider())){
            $token = $event->getToken();

            Mail::send('emails.user_password_recovery', ['user' => $user, 'token' => $token], function ($m) use ($user) {
                $m->to($user->email, $user->name)
                    ->subject('Scelta Nuova Password :: Laravel-Italia.it')
                ;
            });
        }
    }
}
