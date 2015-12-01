<?php

namespace LaravelItalia\Entities\Repositories;


use LaravelItalia\Entities\Role;

/**
 * Class RoleRepository
 * @package LaravelItalia\Entities\Repositories
 */
class RoleRepository
{
    public function findByName($roleName)
    {
        return Role::where('name', '=', $roleName)
            ->first();
    }
}