<?php

namespace LaravelItalia\Events;

use LaravelItalia\Entities\User;
use Illuminate\Queue\SerializesModels;

class UserHasSignedUp extends Event
{
    use SerializesModels;

    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
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
