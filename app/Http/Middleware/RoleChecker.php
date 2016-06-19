<?php

namespace LaravelItalia\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

/**
 * Controlla l'associazione di un determinato utente ad un certo ruolo.
 *
 * Class RoleChecker
 * @package LaravelItalia\Http\Middleware
 */
class RoleChecker
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param ...$roles
     *
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $user = $this->auth->user();

        if (in_array($user->role->name, $roles)) {
            return $next($request);
        }

        if ($user->role->name === 'user') {
            return redirect('access-denied');
        }

        return redirect('admin/dashboard')->with('error_message', 'Non hai i permessi per effettuare questa operazione.');
    }
}
