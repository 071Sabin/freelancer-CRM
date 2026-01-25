<div class="space-y-10 pb-10">
    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif
    <div>
        <flux:heading size="xl">General Settings</flux:heading>
        <flux:subheading>
            Configure your global invoice defaults and localization preferences.
        </flux:subheading>
    </div>

    <flux:separator variant="subtle" />

    <form wire:submit.prevent="save">
        <p>this is general</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-12">

            <div class="md:col-span-1">
                <flux:heading size="lg" class="mb-2">Numbering</flux:heading>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    Set the prefix and starting number for your invoices. These changes will apply to the next
                    invoice
                    generated.
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl">
                    <flux:input label="Prefix" wire:model.defer="prefix" placeholder="INV-"
                        description="Initial of invoice number generated." />

                    <flux:input type="number" label="Next Number" wire:model.defer="next_number"
                        description="Auto-increments after creation." />
                </div>
            </div>
        </div>

        <div class="my-10">
            <flux:separator variant="subtle" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-12">

            <div class="md:col-span-1">
                <flux:heading size="lg" class="mb-2">Localization</flux:heading>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    Define the currency and language used for your customer-facing documents.
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl">
                    <flux:input label="Default Currency" wire:model.defer="default_currency" icon="currency-dollar" />

                    <flux:select label="Language" wire:model.defer="invoice_language" placeholder="Select language...">
                        <option value="en">English</option>
                        <option value="de">German</option>
                    </flux:select>
                </div>
            </div>
        </div>

        <div class="mt-16 pt-6 flex justify-end border-t border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-4">
                <flux:text wire:dirty class="text-amber-500 text-sm">
                    Unsaved changes...
                </flux:text>
                <x-primary-button type="submit">
                    Save Changes
                </x-primary-button>
            </div>
        </div>

    </form>
</div>
