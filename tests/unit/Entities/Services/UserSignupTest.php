<?php

use LaravelItalia\Entities\User;
use LaravelItalia\Entities\Services\UserSignup;
use LaravelItalia\Entities\Repositories\UserRepository;
use LaravelItalia\Events\UserHasSignedUp;

class UserSignupTest extends TestCase
{
    /**
     * @var UserSignup
     */
    private $userSignupService;

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

        $this->userSignupService = new UserSignup($this->userMock);
    }

    public function testExecutesCorrectly()
    {
        $this->repositoryMock
            ->expects($this->once())
            ->method('save');

        $this->expectsEvents(UserHasSignedUp::class);

        $this->userSignupService->handle($this->repositoryMock);
    }
}