<div class="min-h-screen flex items-center justify-center bg-slate-50 dark:bg-black px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-300">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <div class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full z-0 pointer-events-none">
        <div class="absolute top-[-10%] left-[-10%] w-[600px] h-[600px] bg-indigo-500/10 dark:bg-indigo-500/20 rounded-full blur-[80px]"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[600px] h-[600px] bg-emerald-500/10 dark:bg-emerald-500/20 rounded-full blur-[80px]"></div>
    </div>

    <div class="w-full max-w-md bg-white dark:bg-slate-900/60 shadow-2xl rounded-2xl border border-slate-200 dark:border-slate-800 p-8 sm:p-10 transition-all duration-300">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 mb-4 shadow-lg shadow-emerald-500/20">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.957 11.957 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2 class="text-xl lg:text-3xl font-bold tracking-tight text-slate-900 dark:text-white">
                Verify Your Account
            </h2>
            <p class="mt-2 text-xs lg:text-sm text-slate-500 dark:text-slate-400">
                We've sent a 6-digit security code to your email.
            </p>
        </div>

        <form wire:submit="verify" class="space-y-6">
            <div class="space-y-2">
                <label class="block text-center text-xs lg:text-sm font-medium text-slate-700 dark:text-slate-300">
                    Verification Code
                </label>
                <div class="relative">
                    <input 
                        type="text" 
                        wire:model="code" 
                        maxlength="6" 
                        pattern="[0-9]{6}"
                        placeholder="000000" 
                        required 
                        class="block w-full text-center text-2xl font-bold tracking-[1em] pl-4 py-3 border border-slate-200 dark:border-slate-700 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-300 dark:placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all duration-200"
                    >
                </div>
                @error('code')
                    <p class="text-red-500 text-xs mt-1 text-center font-medium flex items-center justify-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                        </svg>
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled"
                class="w-full flex justify-center items-center py-3.5 px-4 border border-transparent rounded-lg shadow-lg shadow-emerald-500/20 text-xs lg:text-sm font-bold text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 disabled:opacity-70 disabled:cursor-not-allowed transition-all duration-200 hover:-translate-y-0.5">

                <svg wire:loading wire:target="verify" class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

                <span wire:loading.remove wire:target="verify">
                    @if (session()->has('registration_data'))
                        Verify Account
                    @else
                        Verify & Log In
                    @endif
                </span>
                <span wire:loading wire:target="verify">Verifying code...</span>
            </button>
        </form>

        <div class="mt-8 text-center border-t border-slate-100 dark:border-slate-800 pt-6">
            <p class="text-xs lg:text-sm text-slate-600 dark:text-slate-400">
                Didn't receive the code?
                <button type="button" wire:click="resend" wire:loading.attr="disabled"
                    class="font-semibold text-emerald-600 hover:text-emerald-500 dark:text-emerald-400 dark:hover:text-emerald-300 transition-colors focus:outline-none disabled:opacity-50">
                    Resend Code
                </button>
            </p>
            <div wire:loading wire:target="resend" class="text-xs text-emerald-600 dark:text-emerald-400 mt-2">
                Sending new code...
            </div>
        </div>
    </div>
</div>
