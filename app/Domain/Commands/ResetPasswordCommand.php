<?php

namespace LaravelItalia\Domain\Commands;


use LaravelItalia\Domain\User;

/**
 * Rappresenta il salvataggio di una nuova password $newPassword per l'utente $user.
 *
 * Class ResetPasswordCommand
 * @package LaravelItalia\Domain\Commands
 */
class ResetPasswordCommand
{
    private $user;
    private $token;
    private $newPassword;

    public function __construct(User $user, $token, $newPassword)
    {
        $this->user = $user;
        $this->token = $token;
        $this->newPassword = $newPassword;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getToken()
    {
        return $this->token;
    }

    public function getNewPassword()
    {
        return $this->newPassword;
    }
}