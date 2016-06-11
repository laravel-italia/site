<?php

use LaravelItalia\Domain\User;
use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Domain\Services\RecoveryPassword;
use LaravelItalia\Domain\Repositories\PasswordResetRepository;

class RecoveryPasswordTest extends TestCase
{
    /**
     * @var RecoveryPassword
     */
    private $service;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|PasswordResetRepository
     */
    private $repositoryMock;

    public function __construct()
    {
        $this->userMock = $this->createMock(\LaravelItalia\Domain\User::class);
        $this->repositoryMock = $this->createMock(PasswordResetRepository::class);

        parent::__construct();
    }

    public function testExecutesCorrectly()
    {
        $this->userMock->expects($this->once())
            ->method('getAuthenticationProvider')
            ->willReturn(null);

        $this->userMock->expects($this->any())
            ->method('getEmail')
            ->willReturn('test@email.com');

        $this->repositoryMock->expects($this->once())
            ->method('add');

        $this->expectsEvents(UserHasRecoveredPassword::class);

        $this->service = new RecoveryPassword($this->userMock);
        $this->service->handle($this->repositoryMock);
    }

    /**
     * @expectedException     \Exception
     * @expectedExceptionMessage social_network_user
     */
    public function testThrowsExceptionIfSocialNetworkUser()
    {
        $this->userMock->expects($this->once())
            ->method('getAuthenticationProvider')
            ->willReturn('facebook');

        $this->service = new RecoveryPassword($this->userMock);
        $this->service->handle($this->repositoryMock);
    }
}
