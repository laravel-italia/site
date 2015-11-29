<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    public function testCanSaveUser()
    {
        $userRepository = new \LaravelItalia\Entities\Repositories\UserRepository();

        $userRepository->save($this->prepareTestUser());

        $users = \LaravelItalia\Entities\User::where('name', '=', 'Francesco')
            ->where('email', '=', 'hey@hellofrancesco.com')
            ->get();

        $this->assertCount(1, $users);
    }

    public function testCanFindFirst()
    {
        $this->prepareTestUserSeed();

        $userRepository = new \LaravelItalia\Entities\Repositories\UserRepository();

        $existingUser = $userRepository->findFirstBy([
            'email' => 'hey@hellofrancesco.com'
        ]);

        $notExistingUser = $userRepository->findFirstBy([
            'name' => 'John Doe'
        ]);

        $this->assertNotNull($existingUser);
        $this->assertNull($notExistingUser);
    }

    private function prepareTestUser()
    {
        $user = new \LaravelItalia\Entities\User();

        $user->name     = 'Francesco';
        $user->email    = 'hey@hellofrancesco.com';
        $user->password = bcrypt('123456');

        return $user;
    }

    private function prepareTestUserSeed()
    {
        $user = $this->prepareTestUser();
        $user->save();
    }
}