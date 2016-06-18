<?php
/**
 * Created by PhpStorm.
 * User: francesco
 * Date: 6/18/16
 * Time: 4:07 PM
 */

namespace LaravelItalia\Domain\Commands\Handlers;


use LaravelItalia\Domain\Commands\ResetPasswordCommand;
use LaravelItalia\Domain\Repositories\PasswordResetRepository;
use LaravelItalia\Domain\Repositories\UserRepository;

class ResetPasswordCommandHandler
{
    private $passwordResetRepository;
    private $userRepository;

    /**
     * ResetPasswordCommandHandler constructor.
     * @param UserRepository $userRepository
     * @param PasswordResetRepository $passwordResetRepository
     */
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