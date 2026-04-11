<div
    class="py-14 flex items-center justify-center bg-slate-50 dark:bg-black px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-300">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif


    @error('loginError')
        <div class="alert alert-danger mt-2">
            {{ $message }}
        </div>
    @enderror


    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
        <div
            class="absolute top-[-10%] right-[-5%] w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-[80px]">
        </div>
        <div
            class="absolute bottom-[-10%] left-[-5%] w-[500px] h-[500px] bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-[80px]">
        </div>
    </div>

    <div
        class="w-full max-w-md bg-white dark:bg-slate-900/60 shadow-2xl rounded-2xl border border-slate-200 dark:border-slate-800 p-8 sm:p-10 transition-all duration-300">

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-indigo-50 dark:bg-indigo-900/30 text-indigo-600 dark:text-indigo-400 mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
            </div>
            <h2 class="text-xl lg:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Welcome back
            </h2>
            <p class="mt-2 text-xs lg:text-sm text-slate-500 dark:text-slate-400">
                Sign in to manage your freelance empire
                <br>
                Total Clients: {{ $totalClients }}
                <br>
                Total Projects: {{ $totalProjects }}
                <br>
                Total Invoices: {{ $totalInvoices }}
            </p>
        </div>

        <div class="space-y-4 mb-6">
            {{-- Error Alert --}}
            @error('loginError')
                <div
                    class="flex items-center gap-3 p-4 text-xs lg:text-sm text-red-800 bg-red-50 dark:bg-red-900/30 dark:text-red-300 border border-red-100 dark:border-red-900/50 rounded-lg animate-pulse-once">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ $message }}</span>
                </div>
            @enderror

            {{-- Success Alert --}}
            @if (session('success'))
                <div
                    class="flex items-center gap-3 p-4 text-xs lg:text-sm text-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900/50 rounded-lg">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span>{{ session('success') }}</span>
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
            class="my-2 justify-center flex items-center gap-2 rounded-lg border border-amber-200/60 bg-amber-50/50 px-3 py-2 text-xs font-medium text-amber-800 shadow-sm backdrop-blur-sm dark:border-amber-500/20 dark:bg-amber-500/5 dark:text-amber-400">
            <svg class="h-3.5 w-3.5 shrink-0 text-amber-600 dark:text-amber-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>

            <div class="flex items-center gap-1.5">
                <span>Security lockout active.</span>
                <span class="flex items-center gap-1 opacity-80">
                    Retry in
                    <span
                        class="inline-flex min-w-[2ch] justify-center font-bold tabular-nums text-amber-700 dark:text-amber-300"
                        x-text="remaining"></span>
                    s
                </span>
            </div>
        </div>
        <form wire:submit="useAuthentication" class="space-y-6">
            @csrf

            {{-- Email Input --}}
            <div class="space-y-1">
                <label class="block text-xs lg:text-sm font-medium text-slate-700 dark:text-slate-300">Email
                    Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                        </svg>
                    </div>
                    <input type="email" wire:model="email"
                        class="block w-full pl-10 pr-3 py-3 border border-slate-200 dark:border-slate-700 rounded-lg leading-5 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 text-xs lg:text-sm"
                        placeholder="you@company.com" required>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Password Input --}}
            <div class="space-y-1">
                <div class="flex items-center justify-between">
                    <label
                        class="block text-xs lg:text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                    <a href="#"
                        class="text-xs lg:text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                        Forgot password?
                    </a>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 lg:h-5 lg:w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <input type="password" wire:model.defer="password"
                        class="block w-full pl-10 pr-3 py-3 border border-slate-200 dark:border-slate-700 rounded-lg leading-5 bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all duration-200 text-xs lg:text-sm"
                        placeholder="••••••••" required>
                </div>
                @error('password')
                    <p class="text-red-500 text-xs mt-1 font-medium flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center py-3 px-4 border border-transparent rounded-lg shadow-lg shadow-indigo-500/20 text-xs lg:text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-70 disabled:cursor-not-allowed transition-all duration-200 hover:-translate-y-0.5">

                <svg wire:loading wire:target="useAuthentication" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span wire:loading.remove wire:target="useAuthentication">Sign In</span>
                <span wire:loading wire:target="useAuthentication">Authenticating...</span>
            </button>
        </form>

        <div class="mt-4 text-center">
            <p class="text-xs lg:text-sm text-slate-600 dark:text-slate-400">
                Don't have an account?
                <a href="{{ route('register') }}" wire:navigate
                    class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                    Start 14-day free trial
                </a>
            </p>
        </div>
    </div>
</div>
