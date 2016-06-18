<?php

namespace LaravelItalia\Domain\Commands;


use LaravelItalia\Domain\Role;
use LaravelItalia\Domain\User;

class AssignRoleToUserCommand
{
    private $user;
    private $role;

    /**
     * AssignRoleToUserCommand constructor.
     * @param $user
     * @param $role
     */
    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
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
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }
}
