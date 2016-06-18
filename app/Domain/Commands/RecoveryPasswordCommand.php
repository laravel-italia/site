<?php

namespace LaravelItalia\Domain\Commands;


class RecoveryPasswordCommand
{
    private $user;

    /**
     * RecoveryPasswordCommand constructor.
     * @param $user
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }
}