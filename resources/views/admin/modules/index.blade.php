@extends('layouts.admin')

@section('title', 'Modules Management')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">Modules Management</h2>
            <p class="text-slate-500 text-sm mt-1">Create and manage learning modules</p>
        </div>
        <a href="{{ route('admin.modules.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm">
            <i data-lucide="plus" class="w-4 h-4"></i>
            Add New Module
        </a>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Title</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Category</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Status</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Created</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($modules as $module)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <span class="font-medium text-slate-900">{{ $module->title }}</span>
                            @if($module->description)
                                <p class="text-xs text-slate-400 mt-0.5 truncate max-w-xs">{{ Str::limit($module->description, 60) }}</p>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 capitalize">
                                {{ str_replace('-', ' ', $module->category) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            @if($module->is_published)
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                                    Published
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                    <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                            {{ $module->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-2">
                                <a href="{{ route('admin.modules.edit', $module) }}"
                                   class="inline-flex items-center gap-1.5 px-3 py-1.5 text-xs font-medium text-blue-700 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors">
                                    <i data-lucide="pencil" class="w-3 h-3"></i>
                                    Edit
                                </a>
                                <form action="{{ route('admin.modules.destroy', $module) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this module? This action cannot be undone.')">
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
                            <i data-lucide="book-open" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                            <p class="text-slate-500 font-medium">No modules yet</p>
                            <p class="text-slate-400 text-xs mt-1">Create your first learning module to get started.</p>
                            <a href="{{ route('admin.modules.create') }}"
                               class="inline-flex items-center gap-2 mt-4 px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                                <i data-lucide="plus" class="w-4 h-4"></i>
                                Add Module
                            </a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($modules->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $modules->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
