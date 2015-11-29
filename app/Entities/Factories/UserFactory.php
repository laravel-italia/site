<?php

namespace LaravelItalia\Entities\Factories;


use LaravelItalia\Entities\User;

/**
 * Class UserFactory
 * @package LaravelItalia\Entities\Factories
 */
class UserFactory
{
    /**
     * Creates a new User instance, starting from name, email and password.
     *
     * @param $fullName
     * @param $emailAddress
     * @param $password
     * @return User
     */
    public static function createUser($fullName, $emailAddress, $password)
    {
        $user = new User;

        $user->name = $fullName;
        $user->email = $emailAddress;
        $user->password = bcrypt($password);

        return $user;
    }
}