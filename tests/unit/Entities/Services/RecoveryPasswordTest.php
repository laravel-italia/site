<?php

use LaravelItalia\Entities\User;
use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Entities\Services\RecoveryPassword;
use LaravelItalia\Entities\Repositories\PasswordResetRepository;

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
        $this->userMock = $this->getMock(\LaravelItalia\Entities\User::class);
        $this->repositoryMock = $this->getMock(PasswordResetRepository::class);

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
