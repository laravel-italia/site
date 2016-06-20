<?php

use Illuminate\Database\Seeder;
use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Repositories\RoleRepository;
use LaravelItalia\Domain\Repositories\UserRepository;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $userRepository = new UserRepository();
        $roleRepository = new RoleRepository();
        $user = User::fromNameAndEmailAndPassword('Francesco Malatesta', 'hey@hellofrancesco.com', '123456');

        $user->role()->associate($roleRepository->findByName('administrator'));
        $user->confirm();

        $userRepository->save($user);
    }
}
