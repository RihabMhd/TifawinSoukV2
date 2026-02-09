<?php

namespace App\Listeners;

use App\Models\Cart;
use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class MergeCartOnLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $oldSessionId = session()->getId();
        
        Log::info('Login event triggered', [
            'user_id' => $event->user->id,
            'session_id' => $oldSessionId
        ]);
        
        Cart::mergeSessionToDatabase($event->user, $oldSessionId);
    }
}