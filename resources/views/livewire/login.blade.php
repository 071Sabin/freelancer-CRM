<div
    class="py-10 flex items-center justify-center bg-white dark:bg-black px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-300">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <div class="w-full max-w-[440px] mx-auto bg-white dark:bg-[#0C0C0C] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] rounded-xl border border-slate-200 dark:border-white/10 p-8 transition-all duration-300">

        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 dark:bg-white/5 dark:border dark:border-white/10 text-slate-900 dark:text-white mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                Welcome back
            </h2>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Sign in to manage your freelance empire.
            </p>
        </div>

        <div class="space-y-4 mb-6">
            {{-- Error Alert --}}
            @error('loginError')
                <div class="flex items-start gap-3 p-3.5 text-sm text-red-900 dark:text-red-200 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-900/50 rounded-md animate-fade-in-up">
                    <svg class="w-5 h-5 flex-shrink-0 text-red-600 dark:text-red-400 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ $message }}</span>
                </div>
            @enderror

            {{-- Success Alert --}}
            @if (session('success'))
                <div class="flex items-start gap-3 p-3.5 text-sm text-slate-900 dark:text-white bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-md animate-fade-in-up">
                    <svg class="w-5 h-5 flex-shrink-0 text-[#172A23] dark:text-white mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
        </div>

        <div x-data="{
            expiry: @entangle('lockoutUntil'),
            remaining: 0,
            init() {
                this.remaining = Math.max(0, this.expiry - Math.floor(Date.now() / 1000));
                setInterval(() => {
                    this.remaining = Math.max(0, this.expiry - Math.floor(Date.now() / 1000));
                }, 1000);
            }
        }" x-show="remaining > 0" x-transition:enter=""
            x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
            class="my-4 justify-center flex items-center gap-2 rounded-md border border-amber-200/60 bg-amber-50/50 px-3 py-2.5 text-xs font-medium text-amber-800 shadow-sm backdrop-blur-sm dark:border-amber-500/20 dark:bg-amber-500/5 dark:text-amber-400">
            <svg class="h-4 w-4 shrink-0 text-amber-600 dark:text-amber-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
            <div class="flex items-center gap-1.5">
                <span>Security lockout active.</span>
                <span class="flex items-center gap-1 opacity-80">
                    Retry in
                    <span class="inline-flex min-w-[2ch] justify-center font-bold tabular-nums text-amber-700 dark:text-amber-300" x-text="remaining"></span>s
                </span>
            </div>
        </div>

        <form wire:submit="useAuthentication" class="space-y-4">
            @csrf

            {{-- Email Input --}}
            <x-input-field type="email" label="Email Address" model="email" placeholder="you@company.com" required />

            {{-- Password Input --}}
            <div class="relative">
                <x-input-field type="password" label="Password" model="password" placeholder="••••••••" required />
                <div class="absolute top-0 right-0 mt-0.5">
                    <a href="#" class="text-xs font-medium text-slate-900 dark:text-white hover:underline underline-offset-4 transition-all">
                        Forgot password?
                    </a>
                </div>
            </div>

            {{-- Submit Button (Brand Integrated) --}}
            <div class="pt-4">
                <button type="submit" wire:loading.attr="disabled"
                    class="group relative w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-slate-900 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 dark:focus:ring-white dark:focus:ring-offset-slate-900 disabled:opacity-60 disabled:cursor-not-allowed transition-colors duration-200">

                    <svg wire:loading wire:target="useAuthentication" class="animate-spin h-4 w-4 text-white/70 dark:text-slate-900/70"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>

                    <span wire:loading.remove wire:target="useAuthentication">Sign In</span>
                    <span wire:loading wire:target="useAuthentication">Authenticating...</span>
                </button>
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Don't have an account? 
                <a href="{{ route('register') }}" wire:navigate class="font-medium text-slate-900 dark:text-white hover:underline underline-offset-4 transition-all">
                    Start 14-day free trial
                </a>
            </p>
        </div>
    </div>
</div>
