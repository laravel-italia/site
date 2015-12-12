<?php

namespace LaravelItalia\Entities\Services;

use LaravelItalia\Entities\Repositories\PasswordResetRepository;
use LaravelItalia\Events\UserHasRecoveredPassword;
use LaravelItalia\Jobs\Job;
use LaravelItalia\Entities\User;
use Illuminate\Contracts\Bus\SelfHandling;

class RecoveryPassword extends Job implements SelfHandling
{
    /**
     * @var User
     */
    private $user;

    /**
     * UserPasswordRecovery constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function handle(PasswordResetRepository $repository)
    {
        if (!is_null($this->user->getAuthenticationProvider())) {
            throw new \Exception('social_network_user');
        }

        $token = $this->generateToken();

        $repository->add(
            $this->user->getEmail(),
            $token
        );

        event(new UserHasRecoveredPassword($this->user, $token));
    }

    private function generateToken()
    {
        return sha1(microtime().$this->user->getEmail());
    }
}
