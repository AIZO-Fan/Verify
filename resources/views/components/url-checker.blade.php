@props(['standalone' => false])

<div
    x-data="{
        loading: false,
        url: '',
        recentChecks: [],

        init() {
            this.loadLocalHistory();
        },

        loadLocalHistory() {
            try {
                const raw = localStorage.getItem('verify_recent_checks');
                this.recentChecks = raw ? JSON.parse(raw) : [];
            } catch (e) {
                this.recentChecks = [];
            }
        },

        submitForm(event) {
            if (!this.url.trim()) return;
            this.loading = true;
            event.target.submit();
        },
    }"
    class="{{ $standalone ? 'w-full' : '' }}"
>
    {{-- URL Input Form --}}
    <form
        method="POST"
        action="{{ route('check-link.check') }}"
        @submit.prevent="submitForm($event)"
        class="{{ $standalone ? 'w-full' : '' }}"
    >
        @csrf

        <div class="{{ $standalone ? 'max-w-2xl mx-auto' : '' }}">

            {{-- Label --}}
            @if ($standalone)
                <h2 class="text-xl font-semibold text-slate-900 mb-1">Check a URL or Link</h2>
                <p class="text-sm text-slate-500 mb-4">Paste any URL below to check if it's safe, suspicious, or a known scam.</p>
            @endif

            {{-- Input + Button Group --}}
            <div class="flex flex-col sm:flex-row gap-2">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <i data-lucide="shield" class="w-4 h-4 text-slate-400"></i>
                    </div>
                    <input
                        type="url"
                        name="url"
                        x-model="url"
                        placeholder="https://example.com/suspicious-link"
                        required
                        autocomplete="off"
                        spellcheck="false"
                        :disabled="loading"
                        class="w-full pl-10 pr-4 py-3 rounded-xl border border-slate-200 bg-white text-slate-900 placeholder-slate-400
                               text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                               disabled:opacity-60 disabled:bg-slate-50 transition-shadow"
                    />
                </div>

                <button
                    type="submit"
                    :disabled="loading || !url.trim()"
                    class="inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-blue-600 hover:bg-blue-700
                           text-white font-semibold text-sm transition-colors duration-150 disabled:opacity-60 disabled:cursor-not-allowed
                           sm:w-auto w-full whitespace-nowrap"
                >
                    {{-- Spinner --}}
                    <svg
                        x-show="loading"
                        x-cloak
                        class="animate-spin w-4 h-4"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                    >
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>

                    <i data-lucide="search" class="w-4 h-4" x-show="!loading"></i>

                    <span x-text="loading ? 'Checking...' : 'Check Now'">Check Now</span>
                </button>
            </div>

            {{-- Helper text --}}
            <p class="mt-2 text-xs text-slate-400 flex items-center gap-1">
                <i data-lucide="lock" class="w-3 h-3"></i>
                URLs are analyzed for security patterns. We don't store your searches without your permission.
            </p>
        </div>
    </form>

    {{-- Past Checks (Standalone mode only) --}}
    @if ($standalone)
        @auth
            {{-- Auth user: server-side history rendered by parent view --}}
            @hasSection('url-checker-history')
                @yield('url-checker-history')
            @endif
        @endauth

        @guest
            {{-- Guest: localStorage-based recent checks --}}
            <div
                x-show="recentChecks.length > 0"
                x-cloak
                class="mt-8"
            >
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-semibold text-slate-700 flex items-center gap-1.5">
                        <i data-lucide="history" class="w-4 h-4 text-slate-400"></i>
                        Recent Checks (this device)
                    </h3>
                    <button
                        @click="localStorage.removeItem('verify_recent_checks'); recentChecks = []"
                        class="text-xs text-slate-400 hover:text-red-500 transition-colors"
                    >Clear</button>
                </div>

                <div class="space-y-2">
                    <template x-for="(check, index) in recentChecks.slice(0, 5)" :key="index">
                        <div class="flex items-center justify-between gap-3 bg-white border border-slate-200 rounded-xl px-4 py-3">
                            <div class="flex items-center gap-3 min-w-0">
                                {{-- Status indicator --}}
                                <div
                                    class="w-2 h-2 rounded-full flex-shrink-0"
                                    :class="{
                                        'bg-green-500': check.status === 'safe',
                                        'bg-red-500':   check.status === 'danger' || check.status === 'phishing',
                                        'bg-amber-500': check.status === 'suspicious' || check.status === 'warning',
                                        'bg-slate-300': !check.status,
                                    }"
                                ></div>
                                <span class="text-sm text-slate-700 truncate font-mono" x-text="check.url"></span>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <span
                                    class="text-xs font-medium px-2 py-0.5 rounded-full"
                                    :class="{
                                        'bg-green-100 text-green-700': check.status === 'safe',
                                        'bg-red-100 text-red-700':     check.status === 'danger' || check.status === 'phishing',
                                        'bg-amber-100 text-amber-700': check.status === 'suspicious' || check.status === 'warning',
                                        'bg-slate-100 text-slate-500': !check.status,
                                    }"
                                    x-text="check.status ? check.status.charAt(0).toUpperCase() + check.status.slice(1) : 'Unknown'"
                                ></span>
                                <span class="text-xs text-slate-400" x-text="check.date"></span>
                            </div>
                        </div>
                    </template>
                </div>

                <div class="mt-3 text-center">
                    <a href="{{ route('register') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium transition-colors">
                        Create an account to save your full check history →
                    </a>
                </div>
            </div>
        @endguest
    @endif
</div>
