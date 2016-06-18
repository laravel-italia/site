<?php

namespace LaravelItalia\Domain\Commands\Handlers;


use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\Commands\AssignRoleToUserCommand;

class AssignRoleToUserCommandHandler
{
    private $userRepository;

    /**
     * AssignRoleToUserCommandHandler constructor.
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(AssignRoleToUserCommand $command)
    {
        $user = $command->getUser();

        $user->role()->associate($command->getRole());
        $this->userRepository->save($user);
    }
}
