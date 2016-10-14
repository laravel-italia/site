<?php

namespace Tests\Unit\Domain\Handlers;

use Mockery;
use Tests\TestCase;
use LaravelItalia\Domain\User;
use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Domain\Commands\RecoveryPasswordCommand;
use LaravelItalia\Domain\Commands\Handlers\RecoveryPasswordCommandHandler;

class RecoveryPasswordCommandHandlerTest extends TestCase
{
    private $userMock;

    /* @var \LaravelItalia\Domain\Repositories\PasswordResetRepository */
    private $passwordResetRepository;

    /* @var RecoveryPasswordCommandHandler */
    private $handler;

    public function setUp()
    {
        parent::setUp();

        $this->userMock = Mockery::mock(User::class);
        $this->userMock->shouldReceive('getEmail')->andReturn('test@email.com');

        $this->passwordResetRepository = Mockery::mock(\LaravelItalia\Domain\Repositories\PasswordResetRepository::class);
        $this->passwordResetRepository->shouldReceive('add')->once();

        $this->expectsEvents(UserHasRecoveredPassword::class);

        $this->handler = new RecoveryPasswordCommandHandler(
            $this->passwordResetRepository
        );
    }

    public function testHandle()
    {
        $this->handler->handle(new RecoveryPasswordCommand(
            $this->userMock
        ));
    }
}
