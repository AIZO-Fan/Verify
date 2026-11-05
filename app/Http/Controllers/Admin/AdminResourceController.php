<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resource;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminResourceController extends Controller
{
    /**
     * The available resource categories.
     */
    private array $categories = [
        'Video',
        'Article',
        'Infographic',
        'Tool',
        'Checklist',
        'Guide',
        'Report',
        'Podcast',
    ];

    /**
     * Display a paginated listing of all resources.
     */
    public function index(Request $request): View
    {
        $query = Resource::orderBy('created_at', 'desc');

        if ($request->filled('category')) {
            $query->where('category', $request->input('category'));
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $resources  = $query->paginate(15)->withQueryString();
        $categories = $this->categories;

        return view('admin.resources.index', compact('resources', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $categories = $this->categories;

        return view('admin.resources.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'url'         => ['required', 'string', 'url', 'max:2048'],
            'source'      => ['nullable', 'string', 'max:255'],
            'language'    => ['required', 'string', 'in:id,en'],
            'is_featured' => ['boolean'],
        ]);

        Resource::create([
            'title'       => $validated['title'],
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'url'         => $validated['url'],
            'source'      => $validated['source'] ?? null,
            'language'    => $validated['language'],
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource "' . $validated['title'] . '" created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Resource $resource): View
    {
        $categories = $this->categories;

        return view('admin.resources.edit', compact('resource', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Resource $resource): RedirectResponse
    {
        $validated = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'category'    => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string', 'max:1000'],
            'url'         => ['required', 'string', 'url', 'max:2048'],
            'source'      => ['nullable', 'string', 'max:255'],
            'language'    => ['required', 'string', 'in:id,en'],
            'is_featured' => ['boolean'],
        ]);

        $resource->update([
            'title'       => $validated['title'],
            'category'    => $validated['category'],
            'description' => $validated['description'] ?? null,
            'url'         => $validated['url'],
            'source'      => $validated['source'] ?? null,
            'language'    => $validated['language'],
            'is_featured' => $request->boolean('is_featured'),
        ]);

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource "' . $validated['title'] . '" updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Resource $resource): RedirectResponse
    {
        $title = $resource->title;
        $resource->delete();

        return redirect()->route('admin.resources.index')
            ->with('success', 'Resource "' . $title . '" deleted successfully.');
    }
}
