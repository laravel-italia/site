<?php

namespace LaravelItalia\Entities\Services;

use LaravelItalia\Entities\User;
use LaravelItalia\Jobs\Job;
use Illuminate\Contracts\Bus\SelfHandling;
use LaravelItalia\Entities\Repositories\UserRepository;

/**
 * Class UserConfirmation
 * @package LaravelItalia\Entities\Services
 */
class UserConfirmation extends Job implements SelfHandling
{
    /**
     * @var User
     */
    private $user;


    /**
     * UserConfirmation constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @param UserRepository $userRepository
     * @throws \Exception
     */
    public function handle(UserRepository $userRepository)
    {
        $this->user->confirm();
        $userRepository->save($this->user);
    }
}
