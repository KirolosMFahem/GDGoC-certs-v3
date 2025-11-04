<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'total_users' => User::where('role', 'leader')->count(),
            'active_users' => User::where('role', 'leader')->where('status', 'active')->count(),
            'suspended_users' => User::where('role', 'leader')->where('status', 'suspended')->count(),
            'terminated_users' => User::where('role', 'leader')->where('status', 'terminated')->count(),
            'recent_logins' => LoginLog::where('success', true)->count(),
            'failed_logins' => LoginLog::where('success', false)->count(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
