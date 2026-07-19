<div
    class="min-h-screen flex items-center justify-center bg-white dark:bg-black px-4 sm:px-6 lg:px-8 relative overflow-hidden transition-colors duration-300">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <div
        class="w-full max-w-[440px] mx-auto bg-white dark:bg-[#0C0C0C] shadow-[0_8px_30px_rgb(0,0,0,0.04)] dark:shadow-[0_8px_30px_rgb(0,0,0,0.2)] rounded-xl border border-slate-200 dark:border-white/10 p-8 transition-all duration-300">

        <div class="mb-8 text-center">
            <div
                class="inline-flex items-center justify-center w-12 h-12 rounded-xl bg-slate-100 dark:bg-white/5 dark:border dark:border-white/10 text-slate-900 dark:text-white mb-4">
                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.957 11.957 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
            </div>
            <h2 class="text-2xl font-semibold tracking-tight text-slate-900 dark:text-white">
                Verify Your Account
            </h2>
            <p class="mt-1.5 text-sm text-slate-500 dark:text-slate-400">
                We've sent a 6-digit security code to your email.
            </p>
        </div>

        <form wire:submit="verify" class="space-y-4">
            <div class="space-y-1.5 w-full">
                <label
                    class="block text-center text-xs lg:text-sm font-medium leading-6 text-neutral-900 transition-colors duration-200 dark:text-neutral-300">
                    Verification Code <span class="ml-0.5 font-bold text-red-500" title="Required">*</span>
                </label>
                <div class="relative">
                    <input type="text" wire:model="code" maxlength="6" pattern="[0-9]{6}" placeholder="0 0 0 0 0 0"
                        required
                        class="block w-full text-center text-xl font-bold tracking-[0.75em] pl-4 py-3 rounded-lg border-0 leading-6 text-neutral-900 bg-white shadow-sm placeholder-neutral-300 focus:ring-1 focus:ring-inset focus:ring-indigo-600 transition-shadow duration-200 ease-in-out dark:border-neutral-600 border border-neutral-200 disabled:cursor-not-allowed disabled:bg-neutral-50 disabled:text-neutral-500 disabled:ring-neutral-200 dark:bg-white/5 dark:text-white dark:ring-neutral-700 dark:placeholder-neutral-500 dark:focus:ring-indigo-500">
                </div>
                @error('code')
                    <p class="mt-2 text-xs text-red-600 dark:text-red-400 text-center">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            <div class="pt-4">
                <button type="submit" wire:loading.attr="disabled"
                    class="group relative w-full flex justify-center items-center gap-2 py-2.5 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-slate-900 hover:bg-slate-800 dark:bg-white dark:text-slate-900 dark:hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-slate-900 dark:focus:ring-white dark:focus:ring-offset-slate-900 disabled:opacity-60 disabled:cursor-not-allowed transition-colors duration-200">

                    <svg wire:loading wire:target="verify"
                        class="animate-spin h-4 w-4 text-white/70 dark:text-slate-900/70"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
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
            </div>
        </form>

        <div class="mt-6 text-center">
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Didn't receive the code?
                <button type="button" wire:click="resend" wire:loading.attr="disabled"
                    class="font-medium text-slate-900 dark:text-white hover:underline underline-offset-4 transition-all focus:outline-none disabled:opacity-50">
                    Resend Code
                </button>
            </p>
            <div wire:loading wire:target="resend" class="text-xs text-slate-500 dark:text-slate-400 mt-2">
                Sending new code...
            </div>
        </div>
    </div>
</div>
