<?php

namespace LaravelItalia\Events;

use LaravelItalia\Entities\User;
use Illuminate\Queue\SerializesModels;

class UserHasRecoveredPassword extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    private $user;

    /**
     * @var string
     */
    private $token;

    /**
     * UserHasRecoveredPassword constructor.
     *
     * @param User   $user
     * @param string $token
     */
    public function __construct(User $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
