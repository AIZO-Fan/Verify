@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-16">
        {{-- Hero --}}
        <div class="text-center max-w-3xl mx-auto">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-800 mb-4">
                <i data-lucide="help-circle" class="w-4 h-4"></i>
                Transparansi Sistem
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight sm:text-5xl">
                Bagaimana VERIFY Bekerja
            </h1>
            <p class="mt-4 text-lg text-slate-600">
                Pahami proses di balik verifikasi tautan, intelijen ancaman, dan batas kemampuan deteksi otomatis untuk membangun pertahanan digital yang kokoh.
            </p>
        </div>

        {{-- 1. How VERIFY Works: 3-Step Flow --}}
        <section class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900 mb-8 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm font-bold">1</span>
                Tiga Langkah Perlindungan Pengguna
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative">
                    <div class="text-blue-600 font-bold text-sm mb-2">LANGKAH 01</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Input & Validasi Tautan</h3>
                    <p class="text-sm text-slate-600">
                        Pengguna memasukkan tautan yang mencurigakan. Sistem memverifikasi format URL, protokol, dan mencegah upaya serangan SSRF atau IP privat.
                    </p>
                </div>

                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative">
                    <div class="text-blue-600 font-bold text-sm mb-2">LANGKAH 02</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Analisis Multi-Lapisan</h3>
                    <p class="text-sm text-slate-600">
                        Sistem mencocokkan target ke Google Safe Browsing API dan menganalisis pola heuristik (domain gratis, impersonasi brand, obfuscation).
                    </p>
                </div>

                <div class="bg-slate-50 rounded-2xl p-6 border border-slate-100 relative">
                    <div class="text-blue-600 font-bold text-sm mb-2">LANGKAH 03</div>
                    <h3 class="text-lg font-bold text-slate-900 mb-2">Hasil & Rekomendasi</h3>
                    <p class="text-sm text-slate-600">
                        Pengguna menerima status kejelasan (Aman, Mencurigakan, Berbahaya, atau Unknown) disertai tindakan mitigasi yang konkret.
                    </p>
                </div>
            </div>
        </section>

        {{-- 2. How Threat Databases Work --}}
        <section class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm font-bold">2</span>
                Cara Kerja Basis Data Ancaman (Threat Intelligence)
            </h2>
            <div class="space-y-4 text-slate-600 text-base leading-relaxed">
                <p>
                    Basis data ancaman seperti <strong>Google Safe Browsing</strong> secara terus-menerus merayapi (crawling) web untuk mengindeks situs yang terinfeksi malware, menyebarkan perangkat lunak tidak diinginkan, atau melakukan phising.
                </p>
                <div class="bg-blue-50 border border-blue-100 rounded-2xl p-6 text-sm text-blue-900 space-y-2">
                    <div class="font-bold">Keunggulan Basis Data Terpusat:</div>
                    <ul class="list-disc list-inside space-y-1 text-blue-800">
                        <li>Mendeteksi kampanye phising masal yang telah dilaporkan ribuan pengguna secara global.</li>
                        <li>Memperbarui daftar ancaman secara real-time setiap beberapa menit.</li>
                        <li>Melindungi miliaran pengguna peramban di seluruh dunia setiap hari.</li>
                    </ul>
                </div>
            </div>
        </section>

        {{-- 3. Identifying Suspicious Websites --}}
        <section class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 shadow-sm">
            <h2 class="text-2xl font-bold text-slate-900 mb-6 flex items-center gap-3">
                <span class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center text-sm font-bold">3</span>
                Ciri-Ciri Utama Situs Palsu & Berbahaya
            </h2>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-400 transition">
                    <div class="flex items-center gap-3 mb-2">
                        <i data-lucide="type" class="w-5 h-5 text-amber-500"></i>
                        <h4 class="font-bold text-slate-900">Typosquatting & Domain Mirip</h4>
                    </div>
                    <p class="text-sm text-slate-600">
                        Penipu mengganti huruf serupa (misal huruf "O" diganti angka "0", atau "l" kecil diganti angka "1") untuk mengecoh pengguna.
                    </p>
                </div>

                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-400 transition">
                    <div class="flex items-center gap-3 mb-2">
                        <i data-lucide="globe" class="w-5 h-5 text-amber-500"></i>
                        <h4 class="font-bold text-slate-900">Ekstensi Domain Murah / Gratis</h4>
                    </div>
                    <p class="text-sm text-slate-600">
                        Penggunaan TLD berisiko tinggi seperti .tk, .ml, .xyz, atau .top yang sering dimanfaatkan untuk situs phising sekali pakai.
                    </p>
                </div>

                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-400 transition">
                    <div class="flex items-center gap-3 mb-2">
                        <i data-lucide="lock" class="w-5 h-5 text-amber-500"></i>
                        <h4 class="font-bold text-slate-900">HTTPS Bukan Jaminan 100%</h4>
                    </div>
                    <p class="text-sm text-slate-600">
                        Gembok hijau/HTTPS hanya menjamin enkripsi transmisi data, bukan kredibilitas atau kejujuran pemilik situs web tersebut.
                    </p>
                </div>

                <div class="border border-slate-200 rounded-2xl p-5 hover:border-blue-400 transition">
                    <div class="flex items-center gap-3 mb-2">
                        <i data-lucide="alert-triangle" class="w-5 h-5 text-amber-500"></i>
                        <h4 class="font-bold text-slate-900">Tekanan Waktu yang Mendesak</h4>
                    </div>
                    <p class="text-sm text-slate-600">
                        Penghitung waktu mundur (countdown timer) palsu atau ancaman penutupan rekening dalam beberapa menit adalah trik psikologis penipu.
                    </p>
                </div>
            </div>
        </section>

        {{-- 4. Limitations & Safe Practices --}}
        <section class="bg-amber-50/60 border border-amber-200 rounded-3xl p-8 sm:p-12">
            <div class="flex items-start gap-4">
                <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
                    <i data-lucide="shield-alert" class="w-6 h-6"></i>
                </div>
                <div>
                    <h2 class="text-xl font-bold text-slate-900 mb-2">
                        Keterbatasan Verifikasi Otomatis (Disclaimer Penting)
                    </h2>
                    <p class="text-sm text-slate-700 leading-relaxed mb-4">
                        Hasil "Aman" atau "Tidak Terdeteksi Ancaman" <strong>TIDAK MENJAMIN 100%</strong> bahwa suatu situs aman tanpa risiko. Penipu dapat membuat domain baru beberapa menit sebelum mengirim pesan (zero-day phishing), sebelum tercatat di basis data mana pun.
                    </p>
                    <p class="text-sm font-semibold text-slate-900">
                        Aturan Emas: Selalu periksa pengirim, jangan bagikan kredensial rahasia, dan gunakan saluran verifikasi resmi (seperti aplikasi resmi bank Anda).
                    </p>
                </div>
            </div>
        </section>

        <div class="text-center pt-4">
            <a href="{{ route('check-link.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 shadow-md transition">
                <i data-lucide="search" class="w-5 h-5"></i>
                Coba Verifikasi Tautan Sekarang
            </a>
        </div>
    </div>
</div>
@endsection
