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

    public function testCanFindById()
    {
        $expectedUser = $this->saveTestUser();

        $user = $this->userRepository->findById($expectedUser->id);

        $this->assertEquals($expectedUser->id, $user->id);
    }

    /**
     * @expectedException \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByIdThrowsException()
    {
        $this->userRepository->findById(999);
    }

    public function testCanFindByEmail()
    {
        $expectedUser = $this->saveTestUser();

        $existingUser = $this->userRepository->findByEmail('hey@hellofrancesco.com');

        $this->assertEquals($expectedUser->id, $existingUser->id);
    }

    /**
     * @expectedException \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByEmailThrowsException()
    {
        $this->userRepository->findByEmail('idontexist@gmail.com');
    }

    public function testCanFindByEmailAndPassword()
    {
        $this->saveTestUser();

        $existingUser = $this->userRepository->findByEmailAndPassword(
            'hey@hellofrancesco.com',
            '123456'
        );

        $this->assertEquals('hey@hellofrancesco.com', $existingUser->email);
    }

    /**
     * @expectedException \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByEmailAndPasswordThrowsException()
    {
        $this->userRepository->findByEmailAndPassword(
            'idont@exist.com',
            'wololo'
        );
    }

    public function testCanFindByConfirmationCode()
    {
        $this->saveTestUser();

        $existingUser = $this->userRepository->findByConfirmationCode('confirmation_code');

        $this->assertEquals('confirmation_code', $existingUser->confirmation_code);
    }

    /**
     * @expectedException \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByConfirmationCodeThrowsException()
    {
        $this->userRepository->findByConfirmationCode('wololooooooo');
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
