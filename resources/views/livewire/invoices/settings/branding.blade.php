<div class="space-y-10 pb-10">

    <div>
        <flux:heading size="xl">Branding</flux:heading>
        <flux:subheading>
            Manage your brand identity across invoices and emails.
        </flux:subheading>
    </div>

    <flux:separator variant="subtle" />

    <form wire:submit.prevent="save">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-12">

            <div class="md:col-span-1">
                <flux:heading size="lg" class="mb-2">Logo & Identity</flux:heading>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    Upload your company logo. This will appear at the top of your invoices and in the header of your
                    client emails.
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="max-w-2xl space-y-6">

                    <div
                        class="p-6 bg-zinc-50 dark:bg-zinc-900/50 border border-zinc-200 dark:border-zinc-700 rounded-xl flex items-center justify-between gap-6">

                        <div class="shrink-0 relative group">
                            <div
                                class="h-24 w-24 rounded-lg bg-white border border-zinc-200 flex items-center justify-center overflow-hidden shadow-sm">
                                @if ($logo)
                                    <img src="{{ $logo->temporaryUrl() }}" class="h-full w-full object-contain p-2" />
                                @elseif ($settings->logo_path)
                                    <img src="{{ asset('storage/' . $settings->logo_path) }}"
                                        class="h-full w-full object-contain p-2" />
                                @else
                                    <svg class="h-8 w-8 text-zinc-300" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                @endif
                            </div>
                        </div>

                        <div class="flex-1">
                            <h3 class="text-sm font-medium text-zinc-900 dark:text-zinc-100">Current Logo</h3>
                            <p class="text-xs text-zinc-500 mt-1">
                                Recommended: 400x400px PNG or JPG. <br>
                                Max file size: 2MB.
                            </p>
                        </div>
                    </div>

                    <flux:input type="file" label="Update Logo" wire:model="logo" variant="filled" />

                    <div wire:loading wire:target="logo" class="text-sm text-zinc-500 flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-zinc-500" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        Uploading and optimizing...
                    </div>

                </div>
            </div>
        </div>

        <div class="mt-16 pt-6 flex justify-end border-t border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-4">
                <flux:text wire:dirty class="text-amber-500 text-sm font-medium animate-pulse">
                    Unsaved changes...
                </flux:text>
                <x-primary-button type="submit">
                    Save Branding
                </x-primary-button>
            </div>
        </div>

    </form>
</div>
