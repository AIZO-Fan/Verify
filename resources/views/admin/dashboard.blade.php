@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
<div class="space-y-6">

    {{-- Page Header --}}
    <div>
        <h2 class="text-2xl font-bold text-slate-900">Dashboard</h2>
        <p class="text-slate-500 text-sm mt-1">Overview of the VERIFY platform</p>
    </div>

    {{-- Stats Row --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        {{-- Users --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center">
                <i data-lucide="users" class="w-6 h-6 text-blue-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $usersCount }}</p>
                <p class="text-sm text-slate-500">Registered Users</p>
            </div>
        </div>

        {{-- Modules --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-indigo-50 flex items-center justify-center">
                <i data-lucide="book-open" class="w-6 h-6 text-indigo-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $modulesCount }}</p>
                <p class="text-sm text-slate-500">Learning Modules</p>
            </div>
        </div>

        {{-- Resources --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-emerald-50 flex items-center justify-center">
                <i data-lucide="library" class="w-6 h-6 text-emerald-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $resourcesCount }}</p>
                <p class="text-sm text-slate-500">Resources</p>
            </div>
        </div>

        {{-- URL Checks --}}
        <div class="bg-white rounded-xl border border-slate-200 p-5 flex items-center gap-4 shadow-sm">
            <div class="flex-shrink-0 w-12 h-12 rounded-lg bg-amber-50 flex items-center justify-center">
                <i data-lucide="shield-check" class="w-6 h-6 text-amber-600"></i>
            </div>
            <div>
                <p class="text-2xl font-bold text-slate-900">{{ $checkHistoriesCount }}</p>
                <p class="text-sm text-slate-500">URL Checks Run</p>
            </div>
        </div>

    </div>

    {{-- Bottom Row: Recent Activity + Quick Actions --}}
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">

        {{-- Recent Activity Table --}}
        <div class="xl:col-span-2 bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-200 flex items-center justify-between">
                <h3 class="font-semibold text-slate-900 flex items-center gap-2">
                    <i data-lucide="activity" class="w-4 h-4 text-blue-600"></i>
                    Recent URL Checks
                </h3>
                <span class="text-xs text-slate-400">Last 10 entries</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-slate-50 border-b border-slate-200">
                        <tr>
                            <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">URL</th>
                            <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Status</th>
                            <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">User</th>
                            <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($recentChecks as $check)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-3 max-w-xs">
                                <span class="truncate block text-slate-700 font-mono text-xs" title="{{ $check->url }}">
                                    {{ Str::limit($check->url, 45) }}
                                </span>
                            </td>
                            <td class="px-6 py-3">
                                @if($check->status === 'safe')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">
                                        <i data-lucide="shield-check" class="w-3 h-3"></i> Safe
                                    </span>
                                @elseif($check->status === 'suspicious')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        <i data-lucide="alert-triangle" class="w-3 h-3"></i> Suspicious
                                    </span>
                                @elseif($check->status === 'dangerous')
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">
                                        <i data-lucide="shield-alert" class="w-3 h-3"></i> Dangerous
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-700">
                                        <i data-lucide="help-circle" class="w-3 h-3"></i> Unknown
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-3 text-slate-600 text-xs">
                                {{ $check->user ? $check->user->email : 'Guest' }}
                            </td>
                            <td class="px-6 py-3 text-slate-500 text-xs whitespace-nowrap">
                                {{ $check->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-8 text-center text-slate-400">
                                <i data-lucide="inbox" class="w-8 h-8 mx-auto mb-2 text-slate-300"></i>
                                <p>No URL checks yet.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Quick Actions --}}
        <div class="bg-white rounded-xl border border-slate-200 shadow-sm p-6 space-y-3">
            <h3 class="font-semibold text-slate-900 flex items-center gap-2 mb-4">
                <i data-lucide="zap" class="w-4 h-4 text-blue-600"></i>
                Quick Actions
            </h3>

            <a href="{{ route('admin.modules.create') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm transition-colors">
                <i data-lucide="plus-circle" class="w-4 h-4"></i>
                Add New Module
            </a>

            <a href="{{ route('admin.resources.create') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-lg bg-indigo-600 hover:bg-indigo-700 text-white font-medium text-sm transition-colors">
                <i data-lucide="file-plus" class="w-4 h-4"></i>
                Add Resource
            </a>

            <a href="{{ route('admin.users.index') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-sm transition-colors">
                <i data-lucide="users" class="w-4 h-4"></i>
                View All Users
            </a>

            <a href="{{ route('admin.modules.index') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-sm transition-colors">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                Manage Modules
            </a>

            <a href="{{ route('admin.resources.index') }}"
               class="flex items-center gap-3 w-full px-4 py-3 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-sm transition-colors">
                <i data-lucide="library" class="w-4 h-4"></i>
                Manage Resources
            </a>
        </div>

    </div>

</div>
@endsection
