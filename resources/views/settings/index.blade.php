@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen" 
     x-data="{
        activeTab: 'about',
        theme: localStorage.getItem('verify_theme') || 'light',
        lang: localStorage.getItem('verify_lang') || 'id',
        notifications: localStorage.getItem('verify_notify') === 'true',
        saved: false,

        savePreferences() {
            localStorage.setItem('verify_theme', this.theme);
            localStorage.setItem('verify_lang', this.lang);
            localStorage.setItem('verify_notify', this.notifications);
            this.saved = true;
            setTimeout(() => this.saved = false, 2500);
        }
     }">

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan & Informasi</h1>
            <p class="text-sm text-slate-600 mt-1">Konfigurasi preferensi peramban dan informasi platform VERIFY.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            {{-- Tabs Sidebar --}}
            <nav class="md:col-span-4 space-y-1">
                <button 
                    @click="activeTab = 'about'"
                    :class="activeTab === 'about' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-100'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition text-left">
                    <i data-lucide="info" class="w-4 h-4"></i>
                    Tentang VERIFY
                </button>

                <button 
                    @click="activeTab = 'preferences'"
                    :class="activeTab === 'preferences' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-100'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition text-left">
                    <i data-lucide="sliders" class="w-4 h-4"></i>
                    Preferensi Tampilan
                </button>

                <button 
                    @click="activeTab = 'privacy'"
                    :class="activeTab === 'privacy' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:bg-slate-100'"
                    class="w-full flex items-center gap-3 px-4 py-3 rounded-xl text-sm transition text-left">
                    <i data-lucide="shield" class="w-4 h-4"></i>
                    Privasi & Data Tamu
                </button>
            </nav>

            {{-- Tab Content Area --}}
            <div class="md:col-span-8 bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-sm">
                {{-- TAB: ABOUT --}}
                <div x-show="activeTab === 'about'" class="space-y-6">
                    <div>
                        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-3">
                            Versi 1.0.0 (Release)
                        </div>
                        <h2 class="text-2xl font-bold text-slate-900 mb-2">Misi Platform VERIFY</h2>
                        <p class="text-slate-600 text-sm leading-relaxed">
                            VERIFY dibangun sebagai platform nirlaba untuk meningkatkan literasi keamanan siber masyarakat dalam menghadapi maraknya penipuan daring, pencurian identitas, rekayasa sosial (social engineering), dan tautan berbahaya.
                        </p>
                    </div>

                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <h3 class="text-base font-bold text-slate-900">Filosofi "Guest First, Account Optional"</h3>
                        <p class="text-sm text-slate-600 leading-relaxed">
                            Kami percaya perlindungan digital harus dapat diakses seketika tanpa hambatan login. Pengguna tamu dapat menggunakan seluruh fitur pengecekan tautan, simulasi, dan materi modul tanpa registrasi akun.
                        </p>
                    </div>

                    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 text-sm text-amber-900">
                        <div class="font-bold mb-1 flex items-center gap-2">
                            <i data-lucide="alert-triangle" class="w-4 h-4 text-amber-600"></i>
                            Batasan Tanggung Jawab (Disclaimer)
                        </div>
                        <p class="text-amber-800 text-xs leading-relaxed">
                            Analisis tautan otomatis memanfaatkan Google Safe Browsing dan analisis heuristik. Hasil verifikasi bukan merupakan jaminan mutlak keselamatan transaksi keuangan Anda.
                        </p>
                    </div>
                </div>

                {{-- TAB: PREFERENCES --}}
                <div x-show="activeTab === 'preferences'" x-cloak class="space-y-6">
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Preferensi Pengguna</h2>
                    <p class="text-slate-500 text-xs">Pengaturan ini disimpan di peramban lokal perangkat Anda.</p>

                    <div class="space-y-6 pt-4 border-t border-slate-100">
                        {{-- Language --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Bahasa Tampilan</label>
                            <select x-model="lang" class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-blue-500">
                                <option value="id">Bahasa Indonesia (Default)</option>
                                <option value="en">English (US)</option>
                            </select>
                        </div>

                        {{-- Theme --}}
                        <div>
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Tema Warna</label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="border rounded-xl p-4 flex items-center gap-3 cursor-pointer"
                                       :class="theme === 'light' ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200'">
                                    <input type="radio" name="theme" value="light" x-model="theme" class="text-blue-600" />
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Terang (Default)</div>
                                        <div class="text-xs text-slate-500">Tampilan bersih SaaS</div>
                                    </div>
                                </label>

                                <label class="border rounded-xl p-4 flex items-center gap-3 cursor-pointer"
                                       :class="theme === 'dark' ? 'border-blue-600 bg-blue-50/50' : 'border-slate-200'">
                                    <input type="radio" name="theme" value="dark" x-model="theme" class="text-blue-600" />
                                    <div>
                                        <div class="text-sm font-bold text-slate-900">Navy Kontras</div>
                                        <div class="text-xs text-slate-500">Aksen gelap minimalis</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Notifications --}}
                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <div class="text-sm font-semibold text-slate-800">Tips Keamanan Peramban</div>
                                <div class="text-xs text-slate-500">Tampilkan pengingat kewaspadaan keamanan saat membuka tautan baru.</div>
                            </div>
                            <input type="checkbox" x-model="notifications" class="w-5 h-5 text-blue-600 rounded" />
                        </div>

                        <div class="pt-4 flex items-center justify-between">
                            <span x-show="saved" class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                                <i data-lucide="check" class="w-4 h-4"></i> Preferensi berhasil disimpan!
                            </span>
                            <div class="ml-auto">
                                <button 
                                    @click="savePreferences()"
                                    class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-xl transition">
                                    Simpan Pengaturan
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: PRIVACY --}}
                <div x-show="activeTab === 'privacy'" x-cloak class="space-y-6">
                    <h2 class="text-2xl font-bold text-slate-900 mb-2">Privasi & Penyimpanan Tamu</h2>

                    <div class="space-y-4 text-sm text-slate-600 leading-relaxed">
                        <p>
                            Saat Anda menggunakan mode tamu (belum masuk), riwayat pengecekan tautan hanya disimpan secara lokal di <code>localStorage</code> peramban Anda. Server VERIFY tidak melacak identitas perangkat tamu.
                        </p>
                        <p>
                            Jika Anda ingin menghapus seluruh jejak pengecekan lokal di peramban ini, klik tombol di bawah:
                        </p>
                    </div>

                    <div class="pt-4 border-t border-slate-100">
                        <button 
                            @click="if(confirm('Hapus seluruh riwayat lokal mode tamu?')) { localStorage.removeItem('verify_guest_history'); alert('Riwayat lokal tamu telah dibersihkan.'); }"
                            class="px-5 py-2.5 border border-red-200 text-red-600 hover:bg-red-50 rounded-xl text-sm font-semibold transition">
                            Hapus Riwayat Peramban Tamu
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
