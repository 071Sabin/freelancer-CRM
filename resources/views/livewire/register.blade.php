<div
    class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-black py-12 px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-300">

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
        <div
            class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-[80px]">
        </div>
        <div
            class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-[80px]">
        </div>
    </div>

    <div
        class="relative z-10 w-full max-w-lg bg-white dark:bg-slate-900 shadow-2xl rounded-2xl border border-slate-200 dark:border-slate-800 p-8 sm:p-10 transition-all duration-300">

        <div class="text-center mb-8">
            <div
                class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 mb-4 shadow-lg shadow-emerald-500/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                </svg>
            </div>
            <h2 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Create your account
            </h2>
            <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">
                Join thousands of freelancers scaling their business
            </p>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-center gap-3 p-4 text-sm text-emerald-800 bg-emerald-50 dark:bg-emerald-900/30 dark:text-emerald-300 border border-emerald-100 dark:border-emerald-900/50 rounded-lg animate-fade-in-up">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit="registerUser" class="space-y-5">

            {{-- Name Field --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Full Name</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <input type="text" wire:model.defer="name" placeholder="John Doe" required
                        class="block w-full pl-10 pr-3 py-3 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 sm:text-sm">
                </div>
                @error('name')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Email Field with Live Spinner --}}
            <div class="space-y-1">
                <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <input type="email" wire:model.live.debounce.700ms="email" placeholder="you@company.com" required
                        class="block w-full pl-10 pr-10 py-3 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 sm:text-sm">

                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                        <svg wire:loading wire:target="email" class="animate-spin h-5 w-5 text-emerald-500"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </div>
                @error('email')
                    <p class="text-red-500 text-xs mt-1 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Passwords Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- Password --}}
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <input type="password" wire:model="password" placeholder="••••••••" required
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 sm:text-sm">
                    </div>
                </div>

                {{-- Confirm Password --}}
                <div class="space-y-1">
                    <label class="block text-sm font-medium text-slate-700 dark:text-slate-300">Confirm</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <input type="password" wire:model="password_confirmation" placeholder="••••••••" required
                            class="block w-full pl-10 pr-3 py-3 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200 sm:text-sm">
                    </div>
                </div>
            </div>

            <div class="flex justify-between items-center min-h-[20px]">
                <div class="flex items-center gap-1.5 text-xs text-slate-400">
                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span>AES-256 Encrypted</span>
                </div>

                {{-- Live Password Checking Text --}}
                <div wire:loading wire:target="password_confirmation"
                    class="text-xs text-emerald-600 dark:text-emerald-400 font-medium animate-pulse">
                    Verifying match...
                </div>

                @error('password')
                    <p class="text-red-500 text-xs font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-lg shadow-lg shadow-emerald-500/20 text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-70 disabled:cursor-not-allowed transition-all duration-200 hover:-translate-y-0.5">

                <svg wire:loading wire:target="registerUser" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>

                <span wire:loading.remove wire:target="registerUser">Create Account</span>
                <span wire:loading wire:target="registerUser">Setting up workspace...</span>
            </button>
        </form>

        <div class="mt-8 text-center border-t border-slate-100 dark:border-slate-800 pt-6">
            <p class="text-sm text-slate-600 dark:text-slate-400">
                Already have an account?
                <a href="{{ route('login') }}" wire:navigate
                    class="font-semibold text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors">
                    Log in here
                </a>
            </p>
        </div>
    </div>
</div>
