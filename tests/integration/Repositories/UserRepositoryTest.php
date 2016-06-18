<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Domain\Repositories\UserRepository;

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

    public function testCanGetAll()
    {
        $this->assertCount(0, $this->userRepository->getAll(1, []));

        $this->saveTestUser();

        $this->assertCount(1, $this->userRepository->getAll(1, []));
    }

    public function testCanGetAllWithCriteria()
    {
        $this->assertCount(0, $this->userRepository->getAll(1, ['name' => 'Francesco']));

        $this->saveTestUser();

        $this->assertCount(1, $this->userRepository->getAll(1, ['name' => 'Francesco']));
        $this->assertCount(0, $this->userRepository->getAll(1, ['name' => 'Lorenzo']));
    }

    public function testCanSaveUser()
    {
        $this->dontSeeInDatabase('users', [
            'name' => 'Francesco',
            'email' => 'hey@hellofrancesco.com',
        ]);

        $this->userRepository->save($this->prepareTestUser());

        $this->seeInDatabase('users', [
            'name' => 'Francesco',
            'email' => 'hey@hellofrancesco.com',
        ]);
    }

    public function testCanGetById()
    {
        $expectedUser = $this->saveTestUser();

        $user = $this->userRepository->findById($expectedUser->id);

        $this->assertEquals($expectedUser->id, $user->id);
    }

    public function testCanFindByEmailAndPassword()
    {
        $this->saveTestUser();

        $existingUser = $this->userRepository->findByEmailAndPassword(
            'hey@hellofrancesco.com',
            '123456'
        );

        $notExistingUser = $this->userRepository->findByEmailAndPassword(
            'idont@exist.com',
            'wololo'
        );

        $this->assertNotNull($existingUser);
        $this->assertNull($notExistingUser);
    }

    public function testCanFindByEmail()
    {
        $this->saveTestUser();

        $existingUser = $this->userRepository->findByEmail('hey@hellofrancesco.com');
        $notExistingUser = $this->userRepository->findByEmail('idont@exist.com');

        $this->assertNotNull($existingUser);
        $this->assertNull($notExistingUser);
    }

    public function testCanFindByConfirmationCode()
    {
        $this->saveTestUser();

        $existingUser = $this->userRepository->findByConfirmationCode('confirmation_code');
        $notExistingUser = $this->userRepository->findByConfirmationCode('i_dont_exist_lol');

        $this->assertNotNull($existingUser);
        $this->assertNull($notExistingUser);
    }

    private function prepareTestUser()
    {
        $user = new \LaravelItalia\Domain\User();

        $user->name = 'Francesco';
        $user->email = 'hey@hellofrancesco.com';
        $user->password = bcrypt('123456');
        $user->is_confirmed = true;
        $user->confirmation_code = 'confirmation_code';

        return $user;
    }

    private function saveTestUser()
    {
        $user = $this->prepareTestUser();
        $user->save();

        return $user;
    }
}
