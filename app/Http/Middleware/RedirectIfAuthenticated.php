<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * @var \Illuminate\Auth\AuthManager
     */
    private $authManager;
    /**
     * @var \Illuminate\Routing\Redirector
     */
    private $redirector;
    public function __construct(\Illuminate\Auth\AuthManager $authManager, \Illuminate\Routing\Redirector $redirector)
    {
        $this->authManager = $authManager;
        $this->redirector = $redirector;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if ($this->authManager->guard($guard)->check()) {
            return $this->redirector->back('/home');
        }

        return $next($request);
    }
}
