<?php

use LaravelItalia\Entities\User;
use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Entities\Services\UserPasswordReset;
use LaravelItalia\Entities\Repositories\UserRepository;
use LaravelItalia\Entities\Repositories\PasswordResetRepository;

class UserPasswordResetTest extends TestCase
{
    /**
     * @var UserPasswordReset
     */
    private $service;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|PasswordResetRepository
     */
    private $passwordRepositoryMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|UserRepository
     */
    private $userRepositoryMock;

    public function __construct()
    {
        $this->userMock = $this->getMock(\LaravelItalia\Entities\User::class);
        $this->passwordRepositoryMock = $this->getMock(PasswordResetRepository::class);
        $this->userRepositoryMock = $this->getMock(UserRepository::class);
    }

    public function testCanResetPasswordCorrectly()
    {
        $this->passwordRepositoryMock->expects($this->once())
            ->method('exists')
            ->willReturn(true);

        $this->userMock->expects($this->once())
            ->method('setNewPassword');

        $this->userRepositoryMock->expects($this->once())
            ->method('save');

        $this->passwordRepositoryMock->expects($this->once())
            ->method('removeByEmail');

        $this->service = new UserPasswordReset($this->userMock, 'TEST_TOKEN', 'NEW_PASSWORD');
        $this->service->handle($this->userRepositoryMock, $this->passwordRepositoryMock);
    }

    /**
     * @expectedException     \Exception
     * @expectedExceptionMessage wrong_email_or_token
     */
    public function testThrowsExceptionIfResetNotFound()
    {
        $this->passwordRepositoryMock->expects($this->once())
            ->method('exists')
            ->willReturn(false);

        $this->userMock->expects($this->never())
            ->method('setNewPassword');

        $this->userRepositoryMock->expects($this->never())
            ->method('save');

        $this->passwordRepositoryMock->expects($this->never())
            ->method('removeByEmail');

        $this->service = new UserPasswordReset($this->userMock, 'TEST_TOKEN', 'NEW_PASSWORD');
        $this->service->handle($this->userRepositoryMock, $this->passwordRepositoryMock);
    }
}