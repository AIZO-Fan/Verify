@extends('layouts.app')

@section('content')
<div class="py-16 bg-slate-50 min-h-[calc(100vh-140px)] flex flex-col justify-center sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center mb-2">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md">
                <i data-lucide="shield" class="w-6 h-6"></i>
            </div>
        </div>
        <h2 class="text-center text-3xl font-extrabold text-slate-900 tracking-tight">
            Masuk ke Akun VERIFY
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Atau
            <a href="{{ route('register') }}" class="font-semibold text-blue-600 hover:text-blue-700">
                daftar akun baru secara gratis
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

            <form action="{{ route('login') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                               class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:border-blue-500 text-sm" />
                    </div>
                </div>

                <div>
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                            Lupa kata sandi?
                        </a>
                    </div>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                               class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:border-blue-500 text-sm" />
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember" name="remember" type="checkbox"
                               class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-slate-300 rounded" />
                        <label for="remember" class="ml-2 block text-xs text-slate-600">
                            Ingat saya di perangkat ini
                        </label>
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition">
                        Masuk
                    </button>
                </div>
            </form>

            <div class="mt-6 pt-6 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500">
                    Akun Demo Pengujian: <br/>
                    <span class="font-mono text-slate-700">admin@verify.com</span> / <span class="font-mono text-slate-700">admin123</span> (Admin)<br/>
                    <span class="font-mono text-slate-700">user@verify.com</span> / <span class="font-mono text-slate-700">user123</span> (User)
                </p>
            </div>
        </div>
    </div>
</div>
@endsection
