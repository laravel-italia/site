<?php

namespace LaravelItalia\Entities\Services;

use LaravelItalia\Events\UserHasSignedUp;
use LaravelItalia\Jobs\Job;
use LaravelItalia\Entities\User;
use Illuminate\Contracts\Bus\SelfHandling;
use LaravelItalia\Entities\Repositories\UserRepository;

/**
 * Class UserSignup
 * @package LaravelItalia\Jobs
 */
class UserSignup extends Job implements SelfHandling
{
    /**
     * @var User
     */
    private $user;


    /**
     * UserSignup constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param UserRepository $userRepository
     */
    public function handle(UserRepository $userRepository)
    {
        $userRepository->save($this->user);

        event(new UserHasSignedUp($this->user));
    }
}
