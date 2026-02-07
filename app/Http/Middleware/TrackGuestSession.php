<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackGuestSession
{
    /**
     * Handle an incoming request.
     *
     * This middleware stores the current session ID in a cookie whenever
     * a guest user interacts with the site. This allows us to retrieve
     * their cart after they log in.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only track if user is NOT authenticated
        if (!auth()->check()) {
            $sessionId = $request->session()->getId();
            
            // Store session ID in a cookie that lasts 2 hours
            cookie()->queue(
                'guest_session_id', 
                $sessionId, 
                120, // 120 minutes
                '/',
                null,
                false, // not HTTPS only (change to true in production)
                false  // accessible to JavaScript (we need this)
            );
        }

        return $next($request);
    }
}