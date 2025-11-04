<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Login;

class LogSuccessfulLogin
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
        LoginLog::create([
            'email' => $event->user->email,
            'ip_address' => request()->ip(),
            'success' => true,
        ]);
    }
}
