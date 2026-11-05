<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Resource;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard page.
     */
    public function index(): View
    {
        $modules = Module::where('is_published', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $resources = Resource::orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        return view('dashboard', compact('modules', 'resources'));
    }
}
