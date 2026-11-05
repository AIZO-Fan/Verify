@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-slate-500 mb-8" aria-label="Breadcrumb">
            <a href="{{ route('dashboard') }}" class="hover:text-blue-600 transition">Beranda</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <a href="{{ route('modules.index') }}" class="hover:text-blue-600 transition">Modul</a>
            <i data-lucide="chevron-right" class="w-4 h-4"></i>
            <span class="text-slate-900 font-medium truncate max-w-xs">{{ $module->title }}</span>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            {{-- Main Content Area --}}
            <main class="lg:col-span-8 bg-white rounded-2xl border border-slate-200 p-6 sm:p-10 shadow-sm">
                {{-- Header --}}
                <div class="mb-6 pb-6 border-b border-slate-100">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-4">
                        <i data-lucide="shield" class="w-3.5 h-3.5"></i>
                        {{ $module->category }}
                    </span>
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 leading-tight mb-4">
                        {{ $module->title }}
                    </h1>
                    <p class="text-lg text-slate-600 leading-relaxed">
                        {{ $module->description }}
                    </p>
                </div>

                {{-- Detailed Article Body --}}
                <div class="prose max-w-none text-slate-700 leading-relaxed space-y-6">
                    {!! $module->content !!}
                </div>

                {{-- Bottom Navigation --}}
                <div class="mt-12 pt-8 border-t border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <a href="{{ route('modules.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-slate-600 hover:text-blue-600 transition">
                        <i data-lucide="arrow-left" class="w-4 h-4"></i>
                        Kembali ke Semua Modul
                    </a>

                    <a href="{{ route('simulator.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 shadow-sm transition">
                        <i data-lucide="gamepad-2" class="w-4 h-4"></i>
                        Uji Pengetahuan di Simulator
                    </a>
                </div>
            </main>

            {{-- Sidebar --}}
            <aside class="lg:col-span-4 space-y-6">
                {{-- Quick Checklist Card --}}
                <div class="bg-blue-50/50 rounded-2xl border border-blue-100 p-6">
                    <div class="flex items-center gap-2 text-blue-900 font-bold mb-4">
                        <i data-lucide="check-square" class="w-5 h-5 text-blue-600"></i>
                        Prinsip Keamanan
                    </div>
                    <ul class="space-y-3 text-sm text-slate-700">
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0"></i>
                            <span>Jangan pernah bagikan OTP / PIN kepada siapa pun.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0"></i>
                            <span>Periksa alamat URL secara teliti sebelum memasukkan sandi.</span>
                        </li>
                        <li class="flex items-start gap-2.5">
                            <i data-lucide="check" class="w-4 h-4 text-emerald-600 mt-0.5 flex-shrink-0"></i>
                            <span>Waspadai pesan yang menuntut tindakan terburu-buru.</span>
                        </li>
                    </ul>
                </div>

                {{-- Related Modules Card --}}
                <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm">
                    <h3 class="font-bold text-slate-900 mb-4 flex items-center gap-2">
                        <i data-lucide="layers" class="w-5 h-5 text-blue-600"></i>
                        Materi Terkait
                    </h3>
                    @php
                        $relatedModules = \App\Models\Module::where('id', '!=', $module->id)->published()->take(4)->get();
                    @endphp
                    <div class="space-y-4">
                        @foreach ($relatedModules as $item)
                            <a href="{{ route('modules.show', $item->slug) }}" class="block group">
                                <span class="text-xs font-semibold text-blue-600 group-hover:underline">{{ $item->category }}</span>
                                <h4 class="text-sm font-semibold text-slate-900 group-hover:text-blue-600 transition line-clamp-2">
                                    {{ $item->title }}
                                </h4>
                            </a>
                        @endforeach
                    </div>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection
