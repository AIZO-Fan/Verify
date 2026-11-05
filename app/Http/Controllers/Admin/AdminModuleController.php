<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminModuleController extends Controller
{
    /**
     * The available module categories.
     */
    private array $categories = [
        'Phishing',
        'Social Engineering',
        'Malware',
        'Password Security',
        'Privacy',
        'Network Security',
        'Mobile Security',
        'Data Protection',
    ];

    /**
     * Display a paginated listing of all modules (published and unpublished).
     */
    public function index(Request $request): View
    {
        $query = Module::orderBy('created_at', 'desc');

        if ($request->filled('status')) {
            $query->where('is_published', $request->input('status') === 'published');
        }

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->input('search') . '%');
        }

        $modules = $query->paginate(15)->withQueryString();

        return view('admin.modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new module.
     */
    public function create(): View
    {
        $categories = $this->categories;

        return view('admin.modules.create', compact('categories'));
    }

    /**
     * Store a newly created module in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'category'     => ['required', 'string', 'max:100'],
            'description'  => ['required', 'string'],
            'content'      => ['required', 'string'],
            'difficulty'   => ['required', 'string', 'in:beginner,intermediate,advanced'],
            'duration'     => ['nullable', 'integer', 'min:1'],
            'thumbnail'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_published' => ['boolean'],
        ]);

        $slug = $this->generateUniqueSlug($validated['title']);

        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('modules', 'public');
        }

        Module::create([
            'title'        => $validated['title'],
            'slug'         => $slug,
            'category'     => $validated['category'],
            'description'  => $validated['description'],
            'content'      => $validated['content'],
            'difficulty'   => $validated['difficulty'],
            'duration'     => $validated['duration'] ?? null,
            'thumbnail'    => $thumbnailPath,
            'is_published' => $request->boolean('is_published'),
            'views'        => 0,
        ]);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module "' . $validated['title'] . '" created successfully.');
    }

    /**
     * Show the form for editing the specified module.
     */
    public function edit(Module $module): View
    {
        $categories = $this->categories;

        return view('admin.modules.edit', compact('module', 'categories'));
    }

    /**
     * Update the specified module in storage.
     */
    public function update(Request $request, Module $module): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:255'],
            'category'     => ['required', 'string', 'max:100'],
            'description'  => ['required', 'string'],
            'content'      => ['required', 'string'],
            'difficulty'   => ['required', 'string', 'in:beginner,intermediate,advanced'],
            'duration'     => ['nullable', 'integer', 'min:1'],
            'thumbnail'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp', 'max:2048'],
            'is_published' => ['boolean'],
        ]);

        // Handle new thumbnail upload
        $thumbnailPath = $module->thumbnail;
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail if it exists
            if ($module->thumbnail && Storage::disk('public')->exists($module->thumbnail)) {
                Storage::disk('public')->delete($module->thumbnail);
            }
            $thumbnailPath = $request->file('thumbnail')->store('modules', 'public');
        }

        // Regenerate slug only if title has changed
        $slug = $module->slug;
        if ($module->title !== $validated['title']) {
            $slug = $this->generateUniqueSlug($validated['title'], $module->id);
        }

        $module->update([
            'title'        => $validated['title'],
            'slug'         => $slug,
            'category'     => $validated['category'],
            'description'  => $validated['description'],
            'content'      => $validated['content'],
            'difficulty'   => $validated['difficulty'],
            'duration'     => $validated['duration'] ?? null,
            'thumbnail'    => $thumbnailPath,
            'is_published' => $request->boolean('is_published'),
        ]);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module "' . $validated['title'] . '" updated successfully.');
    }

    /**
     * Remove the specified module from storage.
     */
    public function destroy(Module $module): RedirectResponse
    {
        // Delete associated thumbnail from disk
        if ($module->thumbnail && Storage::disk('public')->exists($module->thumbnail)) {
            Storage::disk('public')->delete($module->thumbnail);
        }

        $title = $module->title;
        $module->delete();

        return redirect()->route('admin.modules.index')
            ->with('success', 'Module "' . $title . '" deleted successfully.');
    }

    /**
     * Generate a unique slug for a module title, excluding a specific ID on update.
     */
    private function generateUniqueSlug(string $title, ?int $excludeId = null): string
    {
        $baseSlug = Str::slug($title);
        $slug     = $baseSlug;
        $counter  = 1;

        while (true) {
            $query = Module::where('slug', $slug);
            if ($excludeId !== null) {
                $query->where('id', '!=', $excludeId);
            }
            if (!$query->exists()) {
                break;
            }
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
