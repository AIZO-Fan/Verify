@extends('layouts.admin')

@section('title', 'User Management')

@section('content')
<div class="space-y-6">

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-slate-900">User Management</h2>
            <p class="text-slate-500 text-sm mt-1">View and manage all registered users</p>
        </div>
        <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-100 rounded-lg">
            <i data-lucide="users" class="w-4 h-4 text-slate-500"></i>
            <span class="text-sm font-medium text-slate-600">{{ $users->total() }} total</span>
        </div>
    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="bg-slate-50 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Name</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Email</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Role</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Joined</th>
                        <th class="px-6 py-3 text-left font-medium text-slate-500 uppercase tracking-wider text-xs">Checks</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                    <span class="text-xs font-bold text-blue-700">{{ strtoupper(substr($user->name, 0, 1)) }}</span>
                                </div>
                                <span class="font-medium text-slate-900">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-xs font-mono">
                            {{ $user->email }}
                        </td>
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">
                                    <i data-lucide="shield" class="w-3 h-3"></i>
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-600">
                                    <i data-lucide="user" class="w-3 h-3"></i>
                                    User
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-slate-500 text-xs whitespace-nowrap">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 text-slate-600 text-xs">
                            {{ $user->check_histories_count ?? 0 }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <i data-lucide="users" class="w-10 h-10 mx-auto mb-3 text-slate-300"></i>
                            <p class="text-slate-500 font-medium">No users found</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($users->hasPages())
        <div class="px-6 py-4 border-t border-slate-200">
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
