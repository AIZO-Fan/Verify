@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen" 
     x-data="{
        guestItems: [],
        importing: false,
        importSuccess: false,
        init() {
            try {
                const stored = localStorage.getItem('verify_guest_history');
                if (stored) {
                    this.guestItems = JSON.parse(stored);
                }
            } catch (e) {
                console.error(e);
            }
        },
        async importGuestHistory() {
            if (!this.guestItems.length || this.importing) return;
            this.importing = true;
            try {
                const response = await fetch('{{ route('history.import-guest') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ items: this.guestItems })
                });

                if (response.ok) {
                    localStorage.removeItem('verify_guest_history');
                    this.guestItems = [];
                    this.importSuccess = true;
                    setTimeout(() => window.location.reload(), 1500);
                } else {
                    alert('Gagal mengimpor riwayat.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan koneksi.');
            } finally {
                this.importing = false;
            }
        }
     }">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
        {{-- Header --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Pengecekan</h1>
                <p class="text-sm text-slate-600 mt-1">Daftar tautan yang telah Anda verifikasi dan tersimpan aman di akun Anda.</p>
            </div>
            <div>
                <a href="{{ route('check-link.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-semibold rounded-xl hover:bg-blue-700 shadow-sm transition">
                    <i data-lucide="plus-circle" class="w-4 h-4"></i>
                    Verifikasi Tautan Baru
                </a>
            </div>
        </div>

        {{-- Guest History Import Prompt (if found in localStorage) --}}
        <div x-show="guestItems.length > 0" x-cloak class="bg-blue-50 border border-blue-200 rounded-2xl p-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center flex-shrink-0">
                    <i data-lucide="download-cloud" class="w-5 h-5"></i>
                </div>
                <div>
                    <h4 class="font-bold text-blue-900 text-sm">Ditemukan Riwayat Mode Tamu</h4>
                    <p class="text-xs text-blue-700">
                        Ada <span class="font-bold" x-text="guestItems.length"></span> pengecekan dari sesi peramban Anda sebelum masuk. Sinkronkan sekarang ke akun Anda.
                    </p>
                </div>
            </div>
            <button 
                @click="importGuestHistory()" 
                :disabled="importing"
                class="px-4 py-2 bg-blue-600 text-white rounded-xl text-xs font-bold hover:bg-blue-700 transition disabled:opacity-50">
                <span x-show="!importing">Sinkronkan ke Akun</span>
                <span x-show="importing">Menyinkronkan...</span>
            </button>
        </div>

        {{-- Filters & Search --}}
        <div class="bg-white rounded-2xl border border-slate-200 p-5 shadow-sm">
            <form action="{{ route('history.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="lg:col-span-2">
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Cari Tautan URL</label>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari url..." 
                           class="w-full text-sm rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:border-blue-500" />
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Status Keamanan</label>
                    <select name="status" class="w-full text-sm rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:border-blue-500">
                        <option value="">Semua Status</option>
                        <option value="safe" {{ request('status') === 'safe' ? 'selected' : '' }}>Aman (Safe)</option>
                        <option value="suspicious" {{ request('status') === 'suspicious' ? 'selected' : '' }}>Mencurigakan</option>
                        <option value="dangerous" {{ request('status') === 'dangerous' ? 'selected' : '' }}>Berbahaya</option>
                        <option value="unknown" {{ request('status') === 'unknown' ? 'selected' : '' }}>Unknown</option>
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1">Dari Tanggal</label>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" 
                           class="w-full text-sm rounded-xl border border-slate-200 px-3 py-2 focus:outline-none focus:border-blue-500" />
                </div>

                <div class="flex items-end gap-2">
                    <button type="submit" class="flex-1 py-2 px-4 bg-slate-900 text-white rounded-xl text-sm font-semibold hover:bg-slate-800 transition">
                        Filter
                    </button>
                    @if(request()->hasAny(['search', 'status', 'date_from', 'date_to']))
                        <a href="{{ route('history.index') }}" class="p-2 border border-slate-200 rounded-xl hover:bg-slate-50 text-slate-500" title="Reset filter">
                            <i data-lucide="rotate-ccw" class="w-4 h-4"></i>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 overflow-hidden shadow-sm">
            @if ($histories->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm text-slate-600">
                        <thead class="bg-slate-50 text-xs font-bold text-slate-500 uppercase border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-4">Tautan URL</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Waktu Pengecekan</th>
                                <th class="px-6 py-4 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 font-medium">
                            @foreach ($histories as $item)
                                <tr class="hover:bg-slate-50/50 transition">
                                    <td class="px-6 py-4 max-w-md truncate">
                                        <div class="font-semibold text-slate-900 truncate" title="{{ $item->url }}">
                                            {{ $item->url }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if ($item->status === 'safe')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                <i data-lucide="check-circle" class="w-3 h-3"></i>
                                                Aman
                                            </span>
                                        @elseif ($item->status === 'suspicious')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-800">
                                                <i data-lucide="alert-triangle" class="w-3 h-3"></i>
                                                Mencurigakan
                                            </span>
                                        @elseif ($item->status === 'dangerous')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                                                <i data-lucide="x-circle" class="w-3 h-3"></i>
                                                Berbahaya
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-slate-100 text-slate-700">
                                                <i data-lucide="help-circle" class="w-3 h-3"></i>
                                                Unknown
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-xs text-slate-500">
                                        {{ $item->created_at->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right">
                                        <form action="{{ route('history.destroy', $item) }}" method="POST" onsubmit="return confirm('Hapus catatan riwayat ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-slate-400 hover:text-red-600 transition p-1" title="Hapus riwayat">
                                                <i data-lucide="trash-2" class="w-4 h-4"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-slate-100">
                    {{ $histories->links() }}
                </div>
            @else
                <div class="p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i data-lucide="history" class="w-8 h-8"></i>
                    </div>
                    <h3 class="text-base font-bold text-slate-900 mb-1">Belum Ada Riwayat</h3>
                    <p class="text-sm text-slate-500 mb-6">Tautan yang Anda verifikasi saat login akan otomatis tersimpan di sini.</p>
                    <a href="{{ route('check-link.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white rounded-xl text-sm font-semibold hover:bg-blue-700 transition">
                        Verifikasi Tautan Pertama
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
