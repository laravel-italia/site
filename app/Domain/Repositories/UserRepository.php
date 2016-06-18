<?php

namespace LaravelItalia\Domain\Repositories;

use LaravelItalia\Domain\User;
use Illuminate\Support\Facades\Hash;

class UserRepository
{
    public function getAll($page, array $criteria)
    {
        $query = User::with(['role']);

        if (isset($criteria['name'])) {
            $query->where('name', 'LIKE', '%'.$criteria['name'].'%');
        }

        if (isset($criteria['email'])) {
            $query->where('email', 'LIKE', '%'.$criteria['email'].'%');
        }

        if (isset($criteria['role_id'])) {
            $query->where('role_id', '=', $criteria['role_id']);
        }

        return $query->paginate(
            \Config::get('settings.user.users_per_page'),
            ['*'],
            'page',
            $page
        );
    }

    public function findById($id)
    {
        return User::find($id);
    }

    public function findByEmail($emailAddress)
    {
        return User::where('email', '=', $emailAddress)->first();
    }

    public function findByEmailAndPassword($emailAddress, $password)
    {
        $user = $this->findBy([
            'email' => $emailAddress,
            'is_confirmed' => true,
        ]);

        return ($user && Hash::check($password, $user->password)) ? $user : null;
    }

    public function findByConfirmationCode($confirmationCode)
    {
        return $this->findBy([
            'confirmation_code' => $confirmationCode,
        ]);
    }

    private function findBy(array $criteria)
    {
        $users = User::query();

        foreach ($criteria as $fieldName => $fieldValue) {
            $users->where($fieldName, '=', $fieldValue);
        }

        return $users->first();
    }

    public function save(User $user)
    {
        $user->save();
    }
}
