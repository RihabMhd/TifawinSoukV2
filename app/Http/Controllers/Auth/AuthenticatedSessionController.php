<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Cart;
use Illuminate\Support\Facades\Log;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // Get the guest session ID from the cookie BEFORE session regeneration
        $guestSessionId = $request->cookie('guest_session_id');
        
        Log::info('Login attempt', [
            'user_id' => Auth::id(),
            'guest_session_from_cookie' => $guestSessionId,
            'current_session_before_regen' => $request->session()->getId()
        ]);

        $request->session()->regenerate();

        // After login, merge the guest cart if we have a guest session ID
        if ($guestSessionId && Auth::check()) {
            Log::info('Attempting cart merge with guest session from cookie', [
                'user_id' => Auth::id(),
                'guest_session_id' => $guestSessionId,
                'new_session_id' => $request->session()->getId()
            ]);
            
            Cart::mergeSessionToDatabase(Auth::user(), $guestSessionId);
            
            // Clear the cookie after merging
            cookie()->queue(cookie()->forget('guest_session_id'));
        }

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}