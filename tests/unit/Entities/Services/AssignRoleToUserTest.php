<?php

use LaravelItalia\Entities\User;
use LaravelItalia\Entities\Role;
use LaravelItalia\Entities\Services\AssignRoleToUser;
use LaravelItalia\Entities\Repositories\UserRepository;

class AssignRoleToUserTest extends TestCase
{
    /**
     * @var AssignRoleToUser
     */
    private $service;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|User
     */
    private $userMock;

    /**
     * @var PHPUnit_Framework_MockObject_MockObject|UserRepository
     */
    private $repositoryMock;

    /**
     * @var Role
     */
    private $roleMock;


    public function setUp()
    {
        $this->userMock = $this->getMockBuilder(User::class)->setMethods(['role', 'associate'])->getMock();
        $this->roleMock = $this->getMock(Role::class);

        $this->repositoryMock = $this->getMock(UserRepository::class);

        $this->service = new AssignRoleToUser($this->roleMock, $this->userMock);

        parent::__construct();
    }

    public function testExecutesCorrectly()
    {
        $this->userMock->expects($this->once())
            ->method('role')
            ->will($this->returnSelf());

        $this->userMock->expects($this->once())
            ->method('associate');

        $this->repositoryMock
            ->expects($this->once())
            ->method('save');

        $this->service->handle($this->repositoryMock);
    }
}