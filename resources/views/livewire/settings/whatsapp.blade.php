<div>
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif
    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <x-main-heading title="WhatsApp Settings" subtitle="Set up your credentials to send project updates and magic links directly to your clients." />
    
    <div class="mt-6 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden relative">
        @if (!Auth::user()->canUseWhatsApp())
            <div class="absolute inset-0 bg-neutral-50/60 dark:bg-neutral-950/60 backdrop-blur-sm z-10 flex flex-col items-center justify-center text-center p-6 rounded-2xl">
                <div class="flex items-center justify-center w-12 h-12 rounded-full bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white mb-3 border border-neutral-200 dark:border-neutral-700">
                    <x-common.lock class="size-6" />
                </div>
                <h4 class="text-sm font-bold text-neutral-900 dark:text-white">Upgrade Required</h4>
                <p class="text-xs text-neutral-500 max-w-xs mt-1">WhatsApp Cloud API integration is only available on Pro and Agency plans. Upgrade your subscription to unlock this feature.</p>
                <a href="{{ route('pricing') }}" wire:navigate class="mt-4 inline-flex items-center justify-center rounded-lg bg-neutral-900 dark:bg-white px-3.5 py-2 text-xs font-semibold text-white dark:text-neutral-900 hover:bg-neutral-800 dark:hover:bg-neutral-200 transition-colors shadow-sm">
                    View Premium Plans
                </a>
            </div>
        @endif

        <form wire:submit.prevent="saveIntegrations">
            <div class="p-6 sm:p-8 space-y-8">
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3 mb-2">
                        <h3 class="text-xs font-bold tracking-widest text-neutral-500 dark:text-neutral-400 uppercase">
                            WhatsApp Cloud API
                        </h3>
                    </div>

                    <div class="space-y-6 pt-2">
                        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 w-full">
                            <x-input-field label="Permanent Access Token" type="password" model="wa_access_token" required="{{ Auth::user()->canUseWhatsApp() ? 'true' : 'false' }}" placeholder="•••••••••••••••••" disabled="{{ !Auth::user()->canUseWhatsApp() }}" />
                            <x-input-field label="Phone Number ID" type="text" model="wa_phone_number_id" required="{{ Auth::user()->canUseWhatsApp() ? 'true' : 'false' }}" placeholder="WA Phone Number ID" disabled="{{ !Auth::user()->canUseWhatsApp() }}" />
                            <x-input-field label="Business Account ID" type="text" model="wa_business_account_id" required="{{ Auth::user()->canUseWhatsApp() ? 'true' : 'false' }}" placeholder="Business Account ID" disabled="{{ !Auth::user()->canUseWhatsApp() }}" />
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 bg-neutral-50/80 dark:bg-neutral-800/40 border-t border-neutral-200 dark:border-neutral-800 flex items-center justify-end gap-4">
                <span wire:loading class="text-sm font-medium text-neutral-500 dark:text-neutral-400 flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-neutral-900 dark:text-neutral-100" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Saving...
                </span>

                <x-primary-button type="submit" wire:loading.attr="disabled" class="px-6 py-2.5">
                    Save Changes
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
