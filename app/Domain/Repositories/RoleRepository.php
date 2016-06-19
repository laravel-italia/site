<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\Role;

class RoleRepository
{
    /**
     * Restituisce un ruolo a partire dal suo nome identificativo.
     *
     * @param $roleName
     * @return mixed
     */
    public function findByName($roleName)
    {
        return Role::where('name', '=', $roleName)
            ->first();
    }
}
