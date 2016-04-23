<?php

use Illuminate\Database\Seeder;
use LaravelItalia\Domain\Factories\UserFactory;
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
        $user = UserFactory::createUser('Francesco Malatesta', 'hey@hellofrancesco.com', '123456');

        $user->role()->associate($roleRepository->findByName('administrator'));

        $userRepository->save($user);
    }
}
