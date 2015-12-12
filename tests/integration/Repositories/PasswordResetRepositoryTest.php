<?php

use Illuminate\Foundation\Testing\DatabaseMigrations;
use LaravelItalia\Entities\Repositories\PasswordResetRepository;

class PasswordResetRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @var PasswordResetRepository
     */
    private $repository;

    public function setUp()
    {
        $this->repository = new PasswordResetRepository();

        parent::setUp();
    }

    public function testCanSaveNewReset()
    {
        $this->addTestAttempt();

        $this->seeInDatabase('password_resets', [
            'email' => 'test@test.com',
            'token' => 'test_token_yo',
        ]);
    }

    public function testSuccessfulResetSearch()
    {
        $this->addTestAttempt();
        $this->assertTrue($this->repository->exists('test@test.com', 'test_token_yo'));
    }

    public function testUnsuccessfulResetSearch()
    {
        $this->assertFalse($this->repository->exists('test@test.com', 'test_token_yo'));
    }

    public function testCanRemoveAttemptsByEmail()
    {
        $this->addTestAttempt();

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

    private function addTestAttempt()
    {
        $this->repository->add('test@test.com', 'test_token_yo');
    }
}
