<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as BaseAuthenticate;

class AuthenticateWithForbidden extends BaseAuthenticate
{
    protected function redirectTo($request): ?string
    {
        abort(403, 'This action is unauthorized.');
    }
}
