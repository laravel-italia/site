<?php

namespace LaravelItalia\Entities\Repositories;

use Illuminate\Support\Facades\Hash;
use LaravelItalia\Entities\User;

/**
 * Class UserRepository.
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

        foreach ($criteria as $fieldName => $fieldValue) {
            $users->where($fieldName, '=', $fieldValue);
        }

        return $users->first();
    }

    public function findForLogin($emailAddress, $password)
    {
        $user = $this->findFirstBy([
            'email' => $emailAddress,
            'is_confirmed' => true,
        ]);

        return ($user && Hash::check($password, $user->password)) ? $user : null;
    }
}
