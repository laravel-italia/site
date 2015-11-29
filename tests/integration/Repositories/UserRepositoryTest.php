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

    private function prepareTestUser()
    {
        $user = new \LaravelItalia\Entities\User();

        $user->name     = 'Francesco';
        $user->email    = 'hey@hellofrancesco.com';
        $user->password = bcrypt('123456');

        return $user;
    }
}