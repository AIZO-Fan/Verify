@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center max-w-3xl mx-auto mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 mb-4">
                <i data-lucide="shield-check" class="w-4 h-4"></i>
                Referensi Tepercaya
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight sm:text-5xl">
                Pusat Sumber Daya Keamanan
            </h1>
            <p class="mt-4 text-lg text-slate-600">
                Kumpulan rujukan, panduan, dan portal resmi dari otoritas keamanan siber nasional dan internasional.
            </p>
        </div>

        {{-- Grouped Resources by Category --}}
        @foreach ($groupedResources as $category => $items)
            <div class="mb-12">
                <div class="flex items-center gap-3 mb-6 pb-2 border-b border-slate-200">
                    <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                    <h2 class="text-2xl font-bold text-slate-900">{{ $category }}</h2>
                    <span class="text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-0.5 rounded-full">
                        {{ $items->count() }} Sumber
                    </span>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($items as $resource)
                        <div class="bg-white rounded-2xl border border-slate-200 p-6 flex flex-col justify-between hover:shadow-md transition-shadow group">
                            <div>
                                <div class="flex items-center justify-between gap-2 mb-3">
                                    <span class="text-xs font-semibold px-2.5 py-1 rounded-full bg-blue-50 text-blue-700 border border-blue-100">
                                        {{ $resource->source_name }}
                                    </span>
                                    <i data-lucide="external-link" class="w-4 h-4 text-slate-400 group-hover:text-blue-600 transition"></i>
                                </div>
                                <h3 class="text-lg font-bold text-slate-900 mb-2 group-hover:text-blue-600 transition">
                                    {{ $resource->title }}
                                </h3>
                                <p class="text-sm text-slate-600 leading-relaxed mb-6">
                                    {{ $resource->description }}
                                </p>
                            </div>

                            <a href="{{ $resource->url }}" 
                               target="_blank" 
                               rel="noopener noreferrer" 
                               class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-600 text-sm font-semibold rounded-xl border border-slate-200 hover:border-blue-200 transition">
                                <span>Buka Sumber Rujukan</span>
                                <i data-lucide="arrow-up-right" class="w-4 h-4"></i>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        {{-- Verification Disclaimer Box --}}
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-2xl p-6 text-center text-sm text-blue-900 max-w-3xl mx-auto">
            <div class="flex items-center justify-center gap-2 font-bold mb-1">
                <i data-lucide="info" class="w-5 h-5 text-blue-600"></i>
                Catatan Integritas Referensi
            </div>
            <p class="text-blue-800">
                Seluruh tautan luar di atas mengarah langsung ke domain resmi instansi terkemuka (CISA, FTC, NIST, SANS, dan lainnya) untuk memastikan keakuratan informasi dan melindungi Anda dari misinformasi keamanan.
            </p>
        </div>
    </div>
</div>
@endsection
