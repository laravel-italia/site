<?php

namespace Tests\Integration\Repositories;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\Integration\Repositories\Support\EntitiesPreparer;
use LaravelItalia\Domain\Repositories\PasswordResetRepository;

class PasswordResetRepositoryTest extends TestCase
{
    use DatabaseMigrations, EntitiesPreparer;

    /**
     * @var PasswordResetRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new PasswordResetRepository();

        parent::setUp();
    }

    public function testCanFindByEmailAndToken()
    {
        $this->saveTestPasswordReset();

        $passwordReset = $this->repository->findByEmailAndToken('test@test.com', 'test_token_yo');

        $this->assertEquals($passwordReset->email, 'test@test.com');
    }

    /**
     * @expectedException \LaravelItalia\Exceptions\NotFoundException
     */
    public function testCanFindByEmailAndTokenThrowsException()
    {
        $this->repository->findByEmailAndToken('test@test.com', 'test_token_yo');
    }

    public function testCanSave()
    {
        $this->repository->add('test@test.com', 'test_token_yo');

        $this->seeInDatabase('password_resets', [
            'email' => 'test@test.com',
            'token' => 'test_token_yo',
        ]);
    }

    public function testCanRemoveAttemptsByEmail()
    {
        $this->saveTestPasswordReset();

        $this->seeInDatabase('password_resets', [
            'email' => 'test@test.com',
            'token' => 'test_token_yo',
        ]);

        $this->repository->removeByEmail('test@test.com');

        $this->dontSeeInDatabase('password_resets', [
            'email' => 'test@test.com',
            'token' => 'test_token_yo',
        ]);
    }
}
