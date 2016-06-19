<?php

namespace LaravelItalia\Domain\Commands\Handlers;


use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\Commands\ResetPasswordCommand;
use LaravelItalia\Domain\Repositories\PasswordResetRepository;

/**
 * Cambia la password dell'utente specificato con una nuova, appena scelta.
 *
 * Class ResetPasswordCommandHandler
 * @package LaravelItalia\Domain\Commands\Handlers
 */
class ResetPasswordCommandHandler
{
    private $passwordResetRepository;
    private $userRepository;

    public function __construct(PasswordResetRepository $passwordResetRepository, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        $this->passwordResetRepository = $passwordResetRepository;
    }

    public function handle(ResetPasswordCommand $command)
    {
        if (!$this->passwordResetRepository->exists($command->getUser()->getEmail(), $command->getToken())) {
            throw new \Exception('wrong_email_or_token');
        }

        $user = $command->getUser();
        $user->setNewPassword($command->getNewPassword());

        $this->userRepository->save($user);
        $this->passwordResetRepository->removeByEmail($user->getEmail());
    }
}