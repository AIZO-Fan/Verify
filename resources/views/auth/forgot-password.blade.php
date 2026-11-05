@extends('layouts.app')

@section('content')
<div class="py-16 bg-slate-50 min-h-[calc(100vh-140px)] flex flex-col justify-center sm:px-6 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center mb-2">
            <div class="w-12 h-12 rounded-2xl bg-blue-600 text-white flex items-center justify-center shadow-md">
                <i data-lucide="key" class="w-6 h-6"></i>
            </div>
        </div>
        <h2 class="text-center text-3xl font-extrabold text-slate-900 tracking-tight">
            Atur Ulang Kata Sandi
        </h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Masukkan alamat email yang terdaftar untuk menerima tautan pemulihan.
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md px-4">
        <div class="bg-white py-8 px-6 shadow-sm border border-slate-200 rounded-3xl sm:px-10">
            @if (session('status'))
                <div class="mb-4 text-sm font-medium text-emerald-600 bg-emerald-50 p-4 rounded-xl border border-emerald-200">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-sm text-red-700">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="email" class="block text-sm font-semibold text-slate-700">Alamat Email</label>
                    <div class="mt-1">
                        <input id="email" name="email" type="email" required value="{{ old('email') }}"
                               class="appearance-none block w-full px-4 py-2.5 border border-slate-200 rounded-xl placeholder-slate-400 focus:outline-none focus:border-blue-500 text-sm" />
                    </div>
                </div>

                <div>
                    <button type="submit"
                            class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-xl shadow-sm text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition">
                        Kirim Tautan Pemulihan
                    </button>
                </div>
            </form>

            <div class="mt-6 text-center">
                <a href="{{ route('login') }}" class="text-xs font-semibold text-blue-600 hover:underline">
                    ← Kembali ke Halaman Masuk
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
