@extends('layouts.app')

@section('content')
<div class="py-10 bg-slate-50 min-h-screen">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
        {{-- Header --}}
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pengaturan Profil</h1>
            <p class="text-sm text-slate-600 mt-1">Kelola identitas akun dan kredensial keamanan Anda.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- User Identity Card --}}
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-sm text-center">
                <div class="w-20 h-20 bg-blue-600 text-white rounded-full flex items-center justify-center text-2xl font-bold mx-auto mb-4 shadow-sm">
                    {{ strtoupper(substr($user->name, 0, 2)) }}
                </div>
                <h3 class="text-lg font-bold text-slate-900">{{ $user->name }}</h3>
                <p class="text-xs text-slate-500 mb-4">{{ $user->email }}</p>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold {{ $user->isAdmin() ? 'bg-indigo-100 text-indigo-800' : 'bg-slate-100 text-slate-700' }}">
                    <i data-lucide="{{ $user->isAdmin() ? 'shield-check' : 'user' }}" class="w-3.5 h-3.5"></i>
                    {{ ucfirst($user->role) }}
                </div>

                <div class="mt-6 pt-6 border-t border-slate-100 text-left space-y-3 text-xs text-slate-500">
                    <div class="flex justify-between">
                        <span>Bergabung:</span>
                        <span class="font-semibold text-slate-700">{{ $user->created_at->format('d M Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Total Pengecekan:</span>
                        <span class="font-semibold text-slate-700">{{ $user->checkHistories()->count() }} kali</span>
                    </div>
                </div>
            </div>

            {{-- Update Form --}}
            <div class="md:col-span-2 bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 shadow-sm">
                <form action="{{ route('profile.update') }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div>
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-1">Nama Lengkap</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-blue-500 @error('name') border-red-500 @enderror" />
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-semibold text-slate-700 mb-1">Alamat Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-blue-500 @error('email') border-red-500 @enderror" />
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password Change Divider --}}
                    <div class="pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-900 mb-1">Ubah Kata Sandi (Opsional)</h4>
                        <p class="text-xs text-slate-500 mb-4">Kosongkan jika tidak ingin mengganti kata sandi.</p>

                        <div class="space-y-4">
                            <div>
                                <label for="current_password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Saat Ini</label>
                                <input type="password" id="current_password" name="current_password"
                                       class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-blue-500 @error('current_password') border-red-500 @enderror" />
                                @error('current_password')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="new_password" class="block text-xs font-semibold text-slate-700 mb-1">Kata Sandi Baru</label>
                                    <input type="password" id="new_password" name="new_password"
                                           class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-blue-500 @error('new_password') border-red-500 @enderror" />
                                    @error('new_password')
                                        <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="new_password_confirmation" class="block text-xs font-semibold text-slate-700 mb-1">Konfirmasi Kata Sandi Baru</label>
                                    <input type="password" id="new_password_confirmation" name="new_password_confirmation"
                                           class="w-full text-sm rounded-xl border border-slate-200 px-4 py-2.5 focus:outline-none focus:border-blue-500" />
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 text-white font-semibold text-sm rounded-xl hover:bg-blue-700 shadow-sm transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
