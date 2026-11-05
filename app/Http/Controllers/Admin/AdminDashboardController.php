<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CheckHistory;
use App\Models\Module;
use App\Models\Resource;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard with platform-wide statistics.
     */
    public function index(): View
    {
        $totalUsers       = User::count();
        $totalModules     = Module::count();
        $totalResources   = Resource::count();
        $totalChecks      = CheckHistory::count();

        $recentHistories = CheckHistory::with('user')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $safeCount        = CheckHistory::where('status', 'safe')->count();
        $suspiciousCount  = CheckHistory::where('status', 'suspicious')->count();
        $dangerousCount   = CheckHistory::where('status', 'dangerous')->count();
        $unknownCount     = CheckHistory::where('status', 'unknown')->count();

        $publishedModules   = Module::where('is_published', true)->count();
        $unpublishedModules = Module::where('is_published', false)->count();

        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'totalModules',
            'totalResources',
            'totalChecks',
            'recentHistories',
            'safeCount',
            'suspiciousCount',
            'dangerousCount',
            'unknownCount',
            'publishedModules',
            'unpublishedModules',
            'recentUsers'
        ));
    }
}
