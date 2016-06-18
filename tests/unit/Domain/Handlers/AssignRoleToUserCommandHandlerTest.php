<?php

use LaravelItalia\Domain\User;
use LaravelItalia\Domain\Role;
use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\Commands\AssignRoleToUserCommand;
use LaravelItalia\Domain\Commands\Handlers\AssignRoleToUserCommandHandler;

class AssignRoleToUserCommandHandlerTest extends TestCase
{
    private $role;
    private $user;

    /* @var UserRepository */
    private $userRepository;

    /* @var AssignRoleToUserCommandHandler */
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->user = Mockery::mock(User::class);

        $relationshipMock = Mockery::mock(\Illuminate\Database\Eloquent\Relations\BelongsTo::class);
        $relationshipMock->shouldReceive('associate')->once();
        $this->user->shouldReceive('role')->andReturn($relationshipMock);

        $this->role = Mockery::mock(Role::class);
        $this->userRepository = Mockery::mock(UserRepository::class);
        $this->userRepository->shouldReceive('save')->once();

        $this->handler = new AssignRoleToUserCommandHandler(
            $this->userRepository
        );
    }

    public function testHandle()
    {
        $this->handler->handle(new AssignRoleToUserCommand(
            $this->role,
            $this->user
        ));
    }
}
