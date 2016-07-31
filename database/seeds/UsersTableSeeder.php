<?php

use LaravelItalia\Domain\User;
use Illuminate\Database\Seeder;
use LaravelItalia\Domain\Repositories\RoleRepository;
use LaravelItalia\Domain\Repositories\UserRepository;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $rolesRepository = new RoleRepository();
        $userRepository = new UserRepository();
        $role = $rolesRepository->findByName('administrator');

        $user = User::fromNameAndEmailAndPassword(
            'Administrator',
            'admin@email.com',
            '123456'
        );

        $user->confirm();
        $user->role()->associate($role);

        $userRepository->save($user);
    }
}
