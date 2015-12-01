<?php

namespace LaravelItalia\Entities\Services;

use LaravelItalia\Jobs\Job;
use LaravelItalia\Entities\Role;
use LaravelItalia\Entities\User;
use Illuminate\Contracts\Bus\SelfHandling;
use LaravelItalia\Entities\Repositories\UserRepository;

class AssignRoleToUser extends Job implements SelfHandling
{
    /**
     * @var Role
     */
    private $role;
    /**
     * @var User
     */
    private $user;

    /**
     * AssignRoleToUser constructor.
     *
     * @param Role $role
     * @param User $user
     */
    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository)
    {
        $this->user->role()->associate($this->role);
        $userRepository->save($this->user);
    }
}
