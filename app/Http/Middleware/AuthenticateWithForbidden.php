<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;

class AuthenticateWithForbidden extends BaseAuthenticate
{
    /**
     * @param string[] $guards
     */
    protected function unauthenticated($request, array $guards): void
    {
        abort(403, 'This action is unauthorized.');
    }
}
