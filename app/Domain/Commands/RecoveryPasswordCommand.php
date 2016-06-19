<?php

namespace LaravelItalia\Domain\Commands;


/**
 * Rappresenta il recupero delle credenziali di accesso per l'utente $user.
 *
 * Class RecoveryPasswordCommand
 * @package LaravelItalia\Domain\Commands
 */
class RecoveryPasswordCommand
{
    private $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }
}