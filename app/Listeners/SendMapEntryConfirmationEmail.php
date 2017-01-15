<?php

namespace LaravelItalia\Listeners;

use Mail;
use Illuminate\Mail\Message;
use LaravelItalia\Events\MapEntryHasBeenRegistered;

class SendMapEntryConfirmationEmail
{
    /**
     * Handle the event.
     *
     * @param  MapEntryHasBeenRegistered  $event
     * @return void
     */
    public function handle(MapEntryHasBeenRegistered $event)
    {
        $mapEntry = $event->getMapEntry();
        $user = $mapEntry->user;

        Mail::send('emails.map_entry_confirmation', ['user' => $user, 'mapEntry' => $mapEntry], function (Message $m) use ($user) {
            $m->to($user->email, $user->name)
                ->subject('Conferma Aggiunta alla Mappa :: Laravel-Italia.it')
            ;
        });
    }
}
