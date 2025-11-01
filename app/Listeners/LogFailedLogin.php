<?php

namespace App\Listeners;

use App\Models\LoginLog;
use Illuminate\Auth\Events\Failed;

class LogFailedLogin
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
    public function handle(Failed $event): void
    {
        LoginLog::create([
            'email' => $event->credentials['email'] ?? 'unknown',
            'ip_address' => request()->ip(),
            'success' => false,
        ]);
    }
}
