<div class="w-full max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 dark:bg-neutral-800 rounded-2xl py-2">
    <form wire:submit.prevent="saveIntegrations" class="space-y-4">

        <div
            class="bg-white dark:bg-neutral-900 rounded-xl sm:rounded-2xl shadow-sm ring-1 ring-neutral-900/5 dark:ring-neutral-700/50 overflow-hidden transition-all duration-200">
            <div
                class="px-4 sm:px-6 py-4 sm:py-5 border-b border-neutral-900/5 dark:border-neutral-700/50 bg-neutral-50/50 dark:bg-neutral-800/40">
                <h3 class="text-base sm:text-lg font-semibold leading-6 text-neutral-900 dark:text-white">
                    AI Assistant (BYOK)
                </h3>
                <p class="mt-1 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">
                    Configure your Bring Your Own Key settings for automated features like invoice descriptions.
                </p>
            </div>

            <div class="p-4 sm:p-6 space-y-5 sm:space-y-6">
                <div class="max-w-md w-full">
                    <flux:select wire:model="ai_provider" label="AI Provider">
                        <flux:select.option value="openai">OpenAI (ChatGPT)</flux:select.option>
                        <flux:select.option value="gemini">Google Gemini</flux:select.option>
                    </flux:select>
                </div>

                <div class="max-w-xl w-full">
                    <x-input-field label="API Key" type="password" model="ai_api_key" placeholder="sk-..." required />

                    <p class="mt-2.5 flex items-center text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 mr-1.5 sm:mr-2 text-neutral-400 dark:text-neutral-500 shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                        Your key is securely encrypted before saving.
                    </p>
                </div>
            </div>
        </div>

        <div
            class="bg-white dark:bg-neutral-900 rounded-xl sm:rounded-2xl shadow-sm ring-1 ring-neutral-900/5 dark:ring-neutral-700/50 overflow-hidden transition-all duration-200">
            <div
                class="px-4 sm:px-6 py-4 sm:py-5 border-b border-neutral-900/5 dark:border-neutral-700/50 bg-neutral-50/50 dark:bg-neutral-800/40">
                <h3 class="text-base sm:text-lg font-semibold leading-6 text-neutral-900 dark:text-white">
                    WhatsApp Cloud API
                </h3>
                <p class="mt-1 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">
                    Set up your credentials to send project updates and magic links directly to your clients.
                </p>
            </div>

            <div class="p-4 sm:p-6 space-y-5 sm:space-y-6">
                <div class="max-w-xl w-full">
                    <x-input-field label="Permanent Access Token" type="password" model="wa_access_token" required placeholder='*****************' />
                </div>sabin panthi

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6 max-w-2xl w-full">
                    <x-input-field label="Phone Number ID" type="text" model="wa_phone_number_id" required placeholder='WA Phone Number ID' />
                    <x-input-field label="Business Account ID" type="text" model="wa_business_account_id" required placeholder="Business Account ID" />
                </div>
            </div>
        </div>

        <div class="flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between pt-2">

            <div class="flex items-center justify-center sm:justify-start gap-4 min-h-[24px]">
                <span wire:loading
                    class="text-sm font-medium text-neutral-500 dark:text-neutral-400 flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-neutral-900 dark:text-neutral-100"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                    Saving...
                </span>

                @if (session()->has('success'))
                    <span x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3000)"
                        x-transition.opacity.duration.500ms
                        class="text-sm font-medium text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                        <svg class="w-4 h-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ session('success') }}
                    </span>
                @endif
            </div>

            <x-primary-button type="submit" wire:loading.attr="disabled">
                Save Settings
            </x-primary-button>
        </div>
    </form>
</div>
