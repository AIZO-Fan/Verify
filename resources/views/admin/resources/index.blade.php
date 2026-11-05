@extends('layouts.admin')

@section('title', 'Resources Management')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Resources Management</h2>
            <p class="text-slate-500 text-sm mt-1">Manage cybersecurity resource links</p>
        </div>
        <a href="{{ route('admin.resources.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add Resource
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Title</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Source</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Category</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">URL</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($resources as $resource)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-slate-900">{{ $resource->title }}</span>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-xs">
                            {{ $resource->source_name ?? '—' }}
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-50 text-indigo-700 capitalize">
                                {{ str_replace('-', ' ', $resource->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 max-w-xs">
                            <a href="{{ $resource->url }}" target="_blank" rel="noopener noreferrer"
                               class="text-blue-600 hover:underline font-mono text-xs truncate block"
                               title="{{ $resource->url }}">
                                {{ Str::limit($resource->url, 40) }}
                            </a>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.resources.edit', $resource) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                    <i data-lucide="pencil" class="w-3 h-3"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.resources.destroy', $resource) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this resource? This action cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 hover:bg-red-100 rounded-lg transition-colors">
                                        <i data-lucide="trash-2" class="w-3 h-3"></i>
                                        Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i data-lucide="library" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                            <p class="text-slate-500 font-medium">No resources yet</p>
                            <p class="text-slate-400 text-xs mt-1">Add cybersecurity resources for users to explore.</p>
                            <a href="{{ route('admin.resources.create') }}"
                               class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Add Resource
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($resources->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $resources->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
