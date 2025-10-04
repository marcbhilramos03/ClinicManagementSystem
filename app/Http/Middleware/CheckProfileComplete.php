<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckProfileComplete
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->profile_complete) {
            // Correct route names
            $profileEditRoute = $user->role . '.profile.edit';
            $profileUpdateRoute = $user->role . '.profile.update';
            $profileViewRoute = $user->role . '.profile.view';

            $excludedRoutes = [
                $profileEditRoute,
                $profileUpdateRoute,
                $profileViewRoute,
                'logout', // allow logout
            ];

            // Redirect to the profile edit page if not already there
            if (!$request->routeIs(...$excludedRoutes)) {
                return redirect()->route($profileEditRoute);
            }
        }

        return $next($request);
    }
}
