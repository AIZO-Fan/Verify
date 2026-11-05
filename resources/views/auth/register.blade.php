@extends('layouts.app')

@section('content')
<div class="py-16 bg-slate-50 min-h-[calc(100vh-140px)] flex flex-col justify-center sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center mb-2">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md">
                <i data-lucide="shield-plus" class="w-6 h-6"></i>
            </div>
        </div>
        <h2 class="text-center text-3xl font-extrabold text-slate-900 tracking-tight">
            Buat Akun VERIFY
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Sudah memiliki akun?
            <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                Masuk di sini
            </a>
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white py-8 px-6 shadow-sm border border-slate-200 rounded-3xl sm:px-10">
            @if ($errors->any())
                <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                    <ul class="list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" class="space-y-5">
                @csrf

                <div>
                    <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                    <div class="mt-1">
                        <input id="name" name="name" type="text" required value="{{ old('name') }}"
                               placeholder="Contoh: Budi Pratama"
                               class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:border-blue-500 text-sm" />
                    </div>
                </div>

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               placeholder="nama@email.com"
                               class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:border-blue-500 text-sm" />
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" required
                               placeholder="Minimal 8 karakter"
                               class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:border-blue-500 text-sm" />
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Konfirmasi Kata Sandi</label>
                    <div class="mt-1">
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               placeholder="Ulangi kata sandi"
                               class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:border-blue-500 text-sm" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition">
                        Daftar Akun Baru
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Dengan mendaftar, Anda dapat menyinkronkan riwayat pengecekan tautan di seluruh perangkat Anda.
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
