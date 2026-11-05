<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ModuleController extends Controller
{
    /**
     * Display a paginated listing of published modules,
     * optionally filtered by category.
     */
    public function index(Request $request): View
    {
        $query = Module::where('is_published', true)
            ->orderBy('created_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        $modules = $query->paginate(9)->withQueryString();

        $categories = Module::where('is_published', true)
            ->distinct()
            ->pluck('category')
            ->filter()
            ->sort()
            ->values();

        $selectedCategory = $request->input('category');

        return view('modules.index', compact('modules', 'categories', 'selectedCategory'));
    }

    /**
     * Display a single published module by its slug.
     * Increments the view counter on each visit.
     */
    public function show(string $slug): View
    {
        $module = Module::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        // Increment view count without triggering model events
        $module->incrementQuietly('views');

        // Related modules from same category, excluding current
        $relatedModules = Module::where('is_published', true)
            ->where('category', $module->category)
            ->where('id', '!=', $module->id)
            ->take(3)
            ->get();

        return view('modules.show', compact('module', 'relatedModules'));
    }
}
