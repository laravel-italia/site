<?php

namespace LaravelItalia\Domain\Commands;


use LaravelItalia\Domain\Role;
use LaravelItalia\Domain\User;


/**
 * Rappresenta l'assegnazione di un ruolo $role all'utente $user.
 *
 * Class AssignRoleToUserCommand
 * @package LaravelItalia\Domain\Commands
 */
class AssignRoleToUserCommand
{
    private $user;
    private $role;

    public function __construct(Role $role, User $user)
    {
        $this->role = $role;
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getRole()
    {
        return $this->role;
    }
}
