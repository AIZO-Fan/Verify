@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header Section --}}
        <div class="text-center max-w-3xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-4">
                <i data-lucide="book-open" class="w-4 h-4"></i>
                Edukasi Keamanan Digital
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight sm:text-5xl">
                Modul Pembelajaran
            </h1>
            <p class="mt-4 text-lg text-slate-600">
                Tingkatkan pemahaman Anda tentang berbagai ancaman digital, kenali tanda-tanda penipuan, dan pelajari cara melindungi diri secara efektif.
            </p>
        </div>

        {{-- Category Filter Bar --}}
        <div class="mb-8 overflow-x-auto pb-2">
            <div class="flex items-center justify-start md:justify-center gap-2 min-w-max">
                <a href="{{ route('modules.index') }}" 
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ !request('category') ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                    Semua Kategori
                </a>
                @php
                    $categories = [
                        'Phishing Scams',
                        'Online Shopping Scams',
                        'Investment Scams',
                        'Social Engineering',
                        'Fake Websites',
                        'Account Takeover',
                        'OTP Scams',
                        'Digital Identity Theft',
                    ];
                @endphp
                @foreach ($categories as $cat)
                    <a href="{{ route('modules.index', ['category' => $cat]) }}" 
                       class="px-4 py-2 rounded-lg text-sm font-medium transition-colors {{ request('category') === $cat ? 'bg-blue-600 text-white shadow-sm' : 'bg-white text-slate-600 border border-slate-200 hover:bg-slate-50' }}">
                        {{ $cat }}
                    </a>
                @endforeach
            </div>
        </div>

        {{-- Modules Grid --}}
        @if ($modules->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach ($modules as $module)
                    <x-module-card :module="$module" />
                @endforeach
            </div>

            <div class="mt-10">
                {{ $modules->withQueryString()->links() }}
            </div>
        @else
            <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center max-w-md mx-auto">
                <div class="w-16 h-16 bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i data-lucide="search-x" class="w-8 h-8"></i>
                </div>
                <h3 class="text-lg font-bold text-slate-900 mb-1">Belum Ada Modul</h3>
                <p class="text-sm text-slate-500 mb-6">Tidak ditemukan materi untuk kategori yang Anda pilih.</p>
                <a href="{{ route('modules.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition">
                    Lihat Semua Modul
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
