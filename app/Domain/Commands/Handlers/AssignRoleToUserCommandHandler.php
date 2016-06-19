<?php

namespace LaravelItalia\Domain\Commands\Handlers;


use LaravelItalia\Domain\Repositories\UserRepository;
use LaravelItalia\Domain\Commands\AssignRoleToUserCommand;


/**
 * Effettua l'assegnazione di un ruolo ad un certo utente.
 *
 * Class AssignRoleToUserCommandHandler
 * @package LaravelItalia\Domain\Commands\Handlers
 */
class AssignRoleToUserCommandHandler
{
    private $userRepository;

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
