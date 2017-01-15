<?php

namespace LaravelItalia\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Http\Request;
use Illuminate\Session\Store;

class AuthenticateOnSiteFrontend
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
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Closure                  $next
     * @param Store                     $session
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->guest()) {
            /** @var Store $session */
            $session = app()->make(Store::class);
            $session->put('intended', $request->url());

            return redirect('sso/redirect');
        }

        return $next($request);
    }
}
