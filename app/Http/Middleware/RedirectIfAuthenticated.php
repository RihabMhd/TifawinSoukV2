<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                // Check if user is admin and redirect accordingly
                if (Auth::user()->isAdmin()) {
                    return redirect()->route('admin.dashboard');
                }

                if (auth()->user()->isAdmin()) {
                    return redirect()->intended(route('admin.dashboard'));
                }

                return redirect()->intended(route('user.dashboard'));
            }
        }

        return $next($request);
    }
}
