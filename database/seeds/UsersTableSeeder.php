<?php

use Illuminate\Database\Seeder;
use LaravelItalia\Entities\Factories\UserFactory;
use LaravelItalia\Entities\Repositories\RoleRepository;
use LaravelItalia\Entities\Repositories\UserRepository;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userRepository = new UserRepository();
        $roleRepository = new RoleRepository();
        $user = UserFactory::createUser('Francesco Malatesta', 'hey@hellofrancesco.com', '123456');

        $user->role()->associate($roleRepository->findByName('administrator'));

        $userRepository->save($user);

        for($c = 0; $c < 50; $c++) {
            $factory = new Faker\Factory();
            $faker = $factory->create();

            $user = UserFactory::createUser($faker->name, $faker->email, $faker->password(6,8));
            $user->role_id = $faker->numberBetween(1, 3);

            $userRepository->save($user);
        }
    }
}
