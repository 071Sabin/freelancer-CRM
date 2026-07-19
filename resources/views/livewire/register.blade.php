<div
    class="min-h-screen flex items-center justify-center bg-white dark:bg-black px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-300">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <div
        class="w-full max-w-[440px] mx-auto bg-white dark:bg-[#0C0C0C] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] rounded-xl border border-slate-200 dark:border-white/10 p-8 transition-all duration-300">

        <div class="mb-8 text-center">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 dark:bg-white/5 dark:border dark:border-white/10 text-slate-900 dark:text-white mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                Create your account
            </h2>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                Join thousands of freelancers scaling their business.
            </p>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="mb-6 flex items-start gap-3 p-3.5 text-sm text-slate-900 dark:text-white bg-white dark:bg-white/5 border border-slate-200 dark:border-white/10 rounded-md animate-fade-in-up">
                <svg class="w-5 h-5 flex-shrink-0 text-[#172A23] dark:text-white mt-0.5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="font-medium">{{ session('success') }}</span>
            </div>
        @endif

        <form wire:submit="registerUser" class="space-y-4">

            {{-- Name Field --}}
            <x-input-field label="Full Name" model="name" placeholder="Jane Doe" required />

            {{-- Email Field --}}
            <x-input-field type="email" label="Email Address" model="email" placeholder="jane@company.com"
                required />

            {{-- Password --}}
            <x-input-field type="password" label="Password" model="password" placeholder="••••••••" required />

            {{-- Confirm Password --}}
            <x-input-field type="password" label="Confirm Password" model="password_confirmation" placeholder="••••••••"
                required />


            {{-- Submit Button (Brand Integrated) --}}
            <div class="pt-2">
                <button type="submit" wire:loading.attr="disabled"
                    class="group relative w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-slate-900 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 dark:focus:ring-white dark:focus:ring-offset-slate-900 disabled:opacity-60 disabled:cursor-not-allowed transition-colors duration-200">

                    <svg wire:loading wire:target="registerUser"
                        class="animate-spin h-4 w-4 text-white/70 dark:text-slate-900/70"
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
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Already have an account?
                <a href="{{ route('login') }}" wire:navigate
                    class="font-medium text-slate-900 dark:text-white hover:underline underline-offset-4 transition-all">
                    Log in
                </a>
            </p>
        </div>
    </div>
</div>
