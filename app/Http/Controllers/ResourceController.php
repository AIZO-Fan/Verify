<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\View\View;

class ResourceController extends Controller
{
    /**
     * Display all resources grouped by their category.
     */
    public function index(): View
    {
        $groupedResources = Resource::orderBy('category')
            ->orderBy('title')
            ->get()
            ->groupBy('category');

        $categories = $groupedResources->keys()->sort()->values();

        return view('resources.index', compact('groupedResources', 'categories'));
    }
}
