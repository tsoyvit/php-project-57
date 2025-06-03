<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;

class AuthenticateWithForbidden extends BaseAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle($request, Closure $next, ...$guards)
    {
        try {
            $this->authenticate($request, $guards);
        } catch (\Illuminate\Auth\AuthenticationException $e) {
            abort(403, 'Forbidden');
        }

        return $next($request);
    }
}
