<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Role;
use LaravelItalia\Exceptions\NotFoundException;

class RoleRepository
{
    /**
     * Restituisce il ruolo il cui nome è $roleName.
     *
     * @param $roleName
     * @return mixed
     * @throws NotFoundException
     */
    public function findByName($roleName)
    {
        $role = Role::where('name', '=', $roleName)->first();

        if(!$role) {
            throw new NotFoundException;
        }

        return $role;
    }
}
