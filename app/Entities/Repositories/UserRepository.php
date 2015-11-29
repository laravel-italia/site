<?php

namespace LaravelItalia\Entities\Repositories;


use LaravelItalia\Entities\User;

/**
 * Class UserRepository
 * @package LaravelItalia\Entities\Repositories
 */
class UserRepository
{
    /**
     * Saves a User object.
     *
     * @param User $user
     */
    public function save(User $user)
    {
        $user->save();
    }

    public function findFirstBy(array $criteria)
    {
        $users = User::query();

        foreach($criteria as $fieldName => $fieldValue){
            $users->where($fieldName, '=', $fieldValue);
        }

        return $users->first();
    }
}