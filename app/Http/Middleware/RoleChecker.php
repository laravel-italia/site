<?php

namespace LaravelItalia\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

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

        return redirect('/');
    }
}
