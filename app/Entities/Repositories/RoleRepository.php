<?php

namespace LaravelItalia\Entities\Repositories;

use LaravelItalia\Entities\Role;

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
