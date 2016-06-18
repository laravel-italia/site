<?php

namespace LaravelItalia\Domain\Commands\Handlers;


use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Domain\Commands\RecoveryPasswordCommand;
use LaravelItalia\Domain\Repositories\PasswordResetRepository;

class RecoveryPasswordCommandHandler
{
    private $passwordResetRepository;

    /**
     * AssignRoleToUserCommandHandler constructor.
     * @param PasswordResetRepository $passwordResetRepository
     */
    public function __construct(PasswordResetRepository $passwordResetRepository)
    {
        $this->passwordResetRepository = $passwordResetRepository;
    }

    public function handle(RecoveryPasswordCommand $command)
    {
        $token = $this->generateToken($command->getUser()->getEmail());

        $this->passwordResetRepository->add(
            $command->getUser()->getEmail(),
            $token
        );

        event(new UserHasRecoveredPassword($command->getUser(), $token));
    }

    private function generateToken($userEmailAddress)
    {
        return sha1(microtime() . $userEmailAddress);
    }
}
