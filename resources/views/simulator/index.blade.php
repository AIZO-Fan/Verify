@extends('layouts.app')

@section('content')
<div class="py-12 bg-slate-50 min-h-screen" 
     x-data="{
        scenarios: {{ json_encode($scenarios) }},
        currentIndex: 0,
        currentAnswer: null,
        loading: false,
        result: null,
        score: 0,
        completed: false,
        
        async submitAnswer(choice) {
            if (this.loading || this.result) return;
            this.loading = true;
            this.currentAnswer = choice;

            try {
                const response = await fetch('{{ route('simulator.answer') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        scenario_id: this.scenarios[this.currentIndex].id,
                        answer: choice
                    })
                });

                if (response.ok) {
                    const data = await response.json();
                    this.result = data;
                    if (data.correct) {
                        this.score++;
                    }
                } else {
                    alert('Gagal mengirim jawaban. Coba lagi.');
                }
            } catch (err) {
                console.error(err);
                alert('Terjadi kesalahan jaringan.');
            } finally {
                this.loading = false;
            }
        },

        nextScenario() {
            if (this.currentIndex + 1 < this.scenarios.length) {
                this.currentIndex++;
                this.result = null;
                this.currentAnswer = null;
            } else {
                this.completed = true;
            }
        },

        restartSimulator() {
            this.currentIndex = 0;
            this.result = null;
            this.currentAnswer = null;
            this.score = 0;
            this.completed = false;
        }
     }">

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Header --}}
        <div class="text-center max-w-2xl mx-auto mb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-100 text-indigo-800 mb-4">
                <i data-lucide="gamepad-2" class="w-4 h-4"></i>
                Simulasi Interaktif
            </div>
            <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                Scam Simulator
            </h1>
            <p class="mt-3 text-base text-slate-600">
                Uji ketajaman insting keamanan digital Anda dengan menganalisis studi kasus pesan, email, dan penawaran fiktif berikut.
            </p>
        </div>

        {{-- Progress Bar --}}
        <div class="mb-8" x-show="!completed">
            <div class="flex items-center justify-between text-xs font-semibold text-slate-500 mb-2">
                <span>Kasus <span x-text="currentIndex + 1"></span> dari <span x-text="scenarios.length"></span></span>
                <span>Skor Sementara: <span x-text="score" class="text-blue-600 font-bold"></span></span>
            </div>
            <div class="w-full bg-slate-200 rounded-full h-2.5 overflow-hidden">
                <div class="bg-blue-600 h-2.5 rounded-full transition-all duration-300" 
                     :style="`width: ${((currentIndex + 1) / scenarios.length) * 100}%`"></div>
            </div>
        </div>

        {{-- Scenario Card --}}
        <template x-if="!completed">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-6 sm:p-10 space-y-6">
                {{-- Scenario Header --}}
                <div class="flex items-center justify-between pb-4 border-b border-slate-100">
                    <span class="px-3 py-1 bg-slate-100 text-slate-700 rounded-full text-xs font-semibold uppercase tracking-wider"
                          x-text="scenarios[currentIndex].type"></span>
                    <span class="text-xs text-slate-400 font-medium">Fiktif untuk Edukasi</span>
                </div>

                {{-- Scenario Title & Message Box --}}
                <div>
                    <h2 class="text-xl font-bold text-slate-900 mb-4" x-text="scenarios[currentIndex].title"></h2>
                    
                    {{-- Simulated Device Message Box --}}
                    <div class="bg-slate-900 rounded-2xl p-6 text-slate-100 font-mono text-sm leading-relaxed border border-slate-800 shadow-inner">
                        <div class="flex items-center gap-2 mb-4 text-xs text-slate-400 pb-3 border-b border-slate-800">
                            <span class="w-3 h-3 rounded-full bg-red-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-yellow-500 inline-block"></span>
                            <span class="w-3 h-3 rounded-full bg-green-500 inline-block"></span>
                            <span class="ml-2">Pesan Masuk yang Diterima:</span>
                        </div>
                        <div class="whitespace-pre-line text-slate-200" x-text="scenarios[currentIndex].content"></div>
                    </div>
                </div>

                {{-- Action Buttons (When not yet answered) --}}
                <div x-show="!result" class="pt-4">
                    <div class="text-center font-medium text-slate-700 text-sm mb-4">
                        Menurut Anda, apakah pesan di atas resmi atau mencurigakan?
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <button 
                            @click="submitAnswer('legitimate')"
                            :disabled="loading"
                            class="flex items-center justify-center gap-2 py-3 px-6 rounded-xl border-2 border-emerald-500 text-emerald-700 font-bold hover:bg-emerald-50 active:scale-[0.99] transition disabled:opacity-50">
                            <i data-lucide="check-circle" class="w-5 h-5 text-emerald-600"></i>
                            <span>Resmi & Sah</span>
                        </button>

                        <button 
                            @click="submitAnswer('suspicious')"
                            :disabled="loading"
                            class="flex items-center justify-center gap-2 py-3 px-6 rounded-xl bg-red-600 hover:bg-red-700 text-white font-bold active:scale-[0.99] transition shadow-sm disabled:opacity-50">
                            <i data-lucide="alert-triangle" class="w-5 h-5 text-white"></i>
                            <span>Waspada! Mencurigakan</span>
                        </button>
                    </div>
                </div>

                {{-- Loading Spinner --}}
                <div x-show="loading" class="text-center py-6 text-slate-500 text-sm flex items-center justify-center gap-2">
                    <div class="w-5 h-5 border-2 border-blue-600 border-t-transparent rounded-full animate-spin"></div>
                    <span>Menganalisis jawaban Anda...</span>
                </div>

                {{-- Evaluation Result Panel --}}
                <div x-show="result" x-cloak class="pt-4 space-y-6">
                    <div class="rounded-2xl p-6 border"
                         :class="result.correct ? 'bg-emerald-50 border-emerald-200' : 'bg-red-50 border-red-200'">
                        <div class="flex items-center gap-3 mb-2">
                            <template x-if="result.correct">
                                <span class="w-8 h-8 rounded-full bg-emerald-600 text-white flex items-center justify-center font-bold text-sm">✓</span>
                            </template>
                            <template x-if="!result.correct">
                                <span class="w-8 h-8 rounded-full bg-red-600 text-white flex items-center justify-center font-bold text-sm">✗</span>
                            </template>
                            <h3 class="text-lg font-bold" 
                                :class="result.correct ? 'text-emerald-900' : 'text-red-900'"
                                x-text="result.correct ? 'Tepat Sekali! Analisis Anda Benar' : 'Kurang Tepat! Pesan Ini Berbahaya'"></h3>
                        </div>
                        <p class="text-sm leading-relaxed mt-2" 
                           :class="result.correct ? 'text-emerald-800' : 'text-red-800'"
                           x-text="result.explanation"></p>
                    </div>

                    {{-- Warning Signs & Recommendations --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="bg-amber-50 rounded-2xl p-5 border border-amber-200 text-sm">
                            <h4 class="font-bold text-amber-900 mb-2 flex items-center gap-2">
                                <i data-lucide="alert-circle" class="w-4 h-4 text-amber-600"></i>
                                Tanda Peringatan (Red Flags):
                            </h4>
                            <ul class="list-disc list-inside space-y-1 text-amber-800">
                                <template x-for="sign in result.warning_signs" :key="sign">
                                    <li x-text="sign"></li>
                                </template>
                            </ul>
                        </div>

                        <div class="bg-blue-50 rounded-2xl p-5 border border-blue-200 text-sm">
                            <h4 class="font-bold text-blue-900 mb-2 flex items-center gap-2">
                                <i data-lucide="shield-check" class="w-4 h-4 text-blue-600"></i>
                                Tindakan Direkomendasikan:
                            </h4>
                            <ul class="list-disc list-inside space-y-1 text-blue-800">
                                <template x-for="action in result.recommended_actions" :key="action">
                                    <li x-text="action"></li>
                                </template>
                            </ul>
                        </div>
                    </div>

                    {{-- Next Button --}}
                    <div class="text-right pt-2">
                        <button 
                            @click="nextScenario()"
                            class="inline-flex items-center gap-2 px-6 py-2.5 bg-slate-900 hover:bg-slate-800 text-white font-semibold rounded-xl transition">
                            <span x-text="currentIndex + 1 < scenarios.length ? 'Lanjut ke Kasus Berikutnya' : 'Lihat Hasil Akhir'"></span>
                            <i data-lucide="arrow-right" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>
            </div>
        </template>

        {{-- Final Summary Card --}}
        <template x-if="completed">
            <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-8 sm:p-12 text-center space-y-6">
                <div class="w-20 h-20 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center mx-auto">
                    <i data-lucide="award" class="w-10 h-10"></i>
                </div>

                <div>
                    <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Simulasi Selesai!</h2>
                    <p class="text-slate-600">Anda berhasil menganalisis seluruh skenario ancaman.</p>
                </div>

                <div class="bg-slate-50 border border-slate-200 rounded-2xl p-6 max-w-sm mx-auto">
                    <div class="text-sm font-semibold text-slate-500 mb-1">Skor Keseluruhan:</div>
                    <div class="text-4xl font-extrabold text-blue-600">
                        <span x-text="score"></span> / <span x-text="scenarios.length"></span>
                    </div>
                    <p class="text-xs text-slate-500 mt-2" 
                       x-text="score === scenarios.length ? 'Luar biasa! Tingkat kewaspadaan digital Anda sangat tinggi.' : 'Bagus! Terus pelajari modul kami untuk mempertajam kewaspadaan.'"></p>
                </div>

                <div class="flex flex-col sm:flex-row items-center justify-center gap-4 pt-4">
                    <button 
                        @click="restartSimulator()"
                        class="w-full sm:w-auto px-6 py-3 border border-slate-300 rounded-xl font-bold text-slate-700 hover:bg-slate-50 transition">
                        Ulangi Simulasi
                    </button>
                    <a href="{{ route('modules.index') }}" 
                       class="w-full sm:w-auto px-6 py-3 bg-blue-600 text-white rounded-xl font-bold hover:bg-blue-700 shadow-sm transition">
                        Pelajari Modul Lengkap
                    </a>
                </div>
            </div>
        </template>
    </div>
</div>
@endsection
