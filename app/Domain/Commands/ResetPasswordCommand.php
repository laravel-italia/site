<?php

namespace LaravelItalia\Domain\Commands;


use LaravelItalia\Domain\User;

class ResetPasswordCommand
{
    private $user;
    private $token;
    private $newPassword;

    /**
     * ResetPasswordCommand constructor.
     * @param User $user
     * @param $token
     * @param $newPassword
     */
    public function __construct(User $user, $token, $newPassword)
    {
        $this->user = $user;
        $this->token = $token;
        $this->newPassword = $newPassword;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return mixed
     */
    public function getNewPassword()
    {
        return $this->newPassword;
    }
}