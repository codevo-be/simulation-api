<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CustomAuthenticate extends Middleware
{
    protected function redirectTo(Request $request): ?string
    {
        return route('404');
    }

    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            "Échec de l'authentification : vous devez être connecté pour accéder à cette ressource.",
            $guards
        );
    }
}
