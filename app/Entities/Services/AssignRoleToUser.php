<?php

namespace LaravelItalia\Entities\Services;

use Illuminate\Support\Str;
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
     */
    public function handle(UserRepository $userRepository)
    {
        if ($this->role->name == 'administrator' || $this->role->name == 'editor') {
            $this->user->slug = Str::slug($this->user->name.$this->user->id);
        } else {
            $this->user->slug = '';
        }

        $this->user->role()->associate($this->role);
        $userRepository->save($this->user);
    }
}
