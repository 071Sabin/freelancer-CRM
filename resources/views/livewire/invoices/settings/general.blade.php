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

                    <div class="sm:col-span-2">
                        <flux:input label="Number Format" wire:model.defer="number_format"
                            description="Use tokens like {PREFIX} and {NUMBER}." placeholder="{PREFIX}{NUMBER}" />
                    </div>
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

                    <flux:input label="Timezone" wire:model.defer="timezone" placeholder="UTC" />
                    <flux:input label="Date Format" wire:model.defer="date_format" placeholder="Y-m-d" />
                </div>
            </div>
        </div>

        <div class="my-10">
            <flux:separator variant="subtle" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-12">
            <div class="md:col-span-1">
                <flux:heading size="lg" class="mb-2">Company Details</flux:heading>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    These details appear on invoices as your legal business identity.
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl">
                    <flux:input label="Company Name" wire:model.defer="company_name" placeholder="Acme LLC" />
                    <flux:input label="Business Email" wire:model.defer="company_email" placeholder="billing@acme.com" />
                    <flux:input label="Phone" wire:model.defer="company_phone" placeholder="+1 555 0100" />
                    <flux:input label="Website" wire:model.defer="company_website" placeholder="acme.com" />
                    <flux:input label="Tax ID" wire:model.defer="tax_id" placeholder="TAX-12345" />
                </div>

                <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl">
                    <flux:input label="Address Line 1" wire:model.defer="company_address.line1" />
                    <flux:input label="Address Line 2" wire:model.defer="company_address.line2" />
                    <flux:input label="City" wire:model.defer="company_address.city" />
                    <flux:input label="State/Region" wire:model.defer="company_address.state" />
                    <flux:input label="Postal Code" wire:model.defer="company_address.postal_code" />
                    <flux:input label="Country" wire:model.defer="company_address.country" />
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
