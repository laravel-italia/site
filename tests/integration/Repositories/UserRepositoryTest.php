<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Entities\Repositories\UserRepository;

class UserRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var UserRepository
     */
    private $userRepository;

    public function setUp()
    {
        $this->userRepository = new UserRepository();
        parent::setUp();
    }

    public function testCanSaveUser()
    {
        $this->userRepository->save($this->prepareTestUser());

        $users = \LaravelItalia\Entities\User::where('name', '=', 'Francesco')
            ->where('email', '=', 'hey@hellofrancesco.com')
            ->get();

        $this->assertCount(1, $users);
    }

    public function testCanFindFirst()
    {
        $this->prepareTestUserSeed();

        $existingUser = $this->userRepository->findFirstBy([
            'email' => 'hey@hellofrancesco.com'
        ]);

        $notExistingUser = $this->userRepository->findFirstBy([
            'name' => 'John Doe'
        ]);

        $this->assertNotNull($existingUser);
        $this->assertNull($notExistingUser);
    }

    public function testCanFindForLogin()
    {
        $this->prepareTestUserSeed();

        $existingUser = $this->userRepository->findForLogin(
            'hey@hellofrancesco.com',
            '123456'
        );

        $notExistingUser = $this->userRepository->findForLogin(
            'idont@exist.com',
            'wololo'
        );

        $this->assertNotNull($existingUser);
        $this->assertNull($notExistingUser);
    }

    private function prepareTestUser()
    {
        $user = new \LaravelItalia\Entities\User();

        $user->name     = 'Francesco';
        $user->email    = 'hey@hellofrancesco.com';
        $user->password = bcrypt('123456');
        $user->is_confirmed = true;

        return $user;
    }

    private function prepareTestUserSeed()
    {
        $user = $this->prepareTestUser();
        $user->save();
    }
}