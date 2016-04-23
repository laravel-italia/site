<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Role;

/**
 * Class RoleRepository.
 */
class RoleRepository
{
    public function findByName($roleName)
    {
        return Role::where('name', '=', $roleName)
            ->first();
    }
}
