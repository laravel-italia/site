<?php

use LaravelItalia\Entities\User;
use LaravelItalia\Entities\Services\UserConfirmation;
use LaravelItalia\Entities\Repositories\UserRepository;

class UserConfirmatonTest extends TestCase
{
    /**
     * @var UserConfirmation
     */
    private $userConfirmationService;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|UserRepository
     */
    private $repositoryMock;

    public function __construct()
    {
        $this->userMock = $this->getMock(\LaravelItalia\Entities\User::class);
        $this->repositoryMock = $this->getMock(UserRepository::class);

        $this->userConfirmationService = new UserConfirmation($this->userMock);
    }

    public function testExecutesCorrectly()
    {
        $this->userMock
            ->expects($this->once())
            ->method('confirm');

        $this->repositoryMock
            ->expects($this->once())
            ->method('save');

        $this->userConfirmationService->handle($this->repositoryMock);
    }
}