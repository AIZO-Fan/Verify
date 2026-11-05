@extends('layouts.app')

@section('content')
<div class="py-20 bg-slate-50 min-h-[calc(100vh-140px)] flex items-center justify-center px-4">
    <div class="text-center max-w-md bg-white p-10 rounded-3xl border border-slate-200 shadow-sm">
        <div class="w-16 h-16 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
            <i data-lucide="search-x" class="w-8 h-8"></i>
        </div>
        <h1 class="text-4xl font-extrabold text-slate-900 mb-2">404</h1>
        <h2 class="text-lg font-bold text-slate-800 mb-2">Halaman Tidak Ditemukan</h2>
        <p class="text-sm text-slate-500 mb-6">
            Halaman atau tautan materi yang Anda cari tidak tersedia atau telah dipindahkan.
        </p>
        <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
            <i data-lucide="home" class="w-4 h-4"></i>
            Kembali ke Beranda
        </a>
    </div>
</div>
@endsection
