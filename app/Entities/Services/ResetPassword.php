<?php

namespace LaravelItalia\Entities\Services;

use LaravelItalia\Entities\Repositories\PasswordResetRepository;
use LaravelItalia\Entities\Repositories\UserRepository;
use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Jobs\Job;
use LaravelItalia\Entities\User;
use Illuminate\Contracts\Bus\SelfHandling;

class ResetPassword extends Job implements SelfHandling
{
    /**
     * @var User
     */
    private $user;


    /**
     * @var string
     */
    private $token;

    /**
     * @var string
     */
    private $newPassword;

    /**
     * UserPasswordReset constructor.
     * @param User $user
     * @param string $token
     * @param string $newPassword
     */
    public function __construct(User $user, $token, $newPassword)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function handle(UserRepository $userRepository, PasswordResetRepository $passwordResetRepository)
    {
        if(!$passwordResetRepository->exists($this->user->getEmail(), $this->token))
            throw new \Exception('wrong_email_or_token');

        $this->user->setNewPassword($this->newPassword);

        $userRepository->save($this->user);
        $passwordResetRepository->removeByEmail($this->user->getEmail());
    }
}