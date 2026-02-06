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

    <form wire:submit.prevent="save" class="space-y-12 pb-24">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-1">
                <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">Numbering</h3>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                    Set the prefix and starting number for your invoices. These changes will apply to the next invoice
                    generated.
                </p>
            </div>

            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div class="space-y-1">
                        <x-input-field label="Prefix" model="prefix" placeholder="INV-" />
                        <p class="text-[11px] text-neutral-400 dark:text-neutral-500">e.g. INV-001</p>
                    </div>

                    <div class="space-y-1">
                        <x-input-field type="number" label="Next Number" model="next_number" />
                        <p class="text-[11px] text-neutral-400 dark:text-neutral-500">Auto-increments</p>
                    </div>

                    <div class="sm:col-span-2 space-y-1">
                        <x-input-field label="Number Format" model="number_format" placeholder="{PREFIX}{NUMBER}" />
                        <p class="text-[11px] text-neutral-400 dark:text-neutral-500 font-mono">
                            Available tokens: {PREFIX}, {NUMBER}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-t border-neutral-200 dark:border-neutral-800"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-1">
                <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">Localization</h3>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                    Define the currency, language, and date formats used for your customer-facing documents.
                </p>
            </div>

            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <x-input-field label="Default Currency" model="default_currency" placeholder="USD" />

                    <div class="w-full group">
                        <label class="block text-sm font-medium leading-6 text-neutral-800 dark:text-white mb-2">
                            Language
                        </label>
                        <div class="relative">
                            <select wire:model.defer="invoice_language"
                                class="block w-full rounded-lg border-0 py-2.5 px-3 text-neutral-800 dark:text-white bg-white dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 text-base sm:text-sm sm:leading-6 transition-shadow duration-200 ease-in-out">
                                <option value="">Select language...</option>
                                <option value="en">English</option>
                                <option value="de">German</option>
                                <option value="es">Spanish</option>
                                <option value="fr">French</option>
                            </select>
                        </div>
                    </div>

                    <x-input-field label="Timezone" model="timezone" placeholder="UTC" />
                    <x-input-field label="Date Format" model="date_format" placeholder="Y-m-d" />
                </div>
            </div>
        </div>

        <div class="border-t border-neutral-200 dark:border-neutral-800"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-1">
                <h3 class="text-lg font-semibold text-neutral-800 dark:text-white">Company Details</h3>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                    These details appear on invoices as your legal business identity.
                </p>
            </div>

            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div class="sm:col-span-2">
                        <x-input-field label="Company Name" model="company_name" placeholder="Acme LLC" />
                    </div>

                    <x-input-field label="Business Email" type="email" model="company_email"
                        placeholder="billing@acme.com" />
                    <x-input-field label="Phone" type="tel" model="company_phone" placeholder="+1 555 0100" />
                    <x-input-field label="Website" model="company_website" placeholder="acme.com" />
                    <x-input-field label="Tax ID / VAT" model="tax_id" placeholder="TAX-12345" />

                    <div class="sm:col-span-2 border-t border-neutral-100 dark:border-neutral-800 my-2"></div>

                    <div class="sm:col-span-2">
                        <x-input-field label="Address Line 1" model="company_address.line1" />
                    </div>
                    <div class="sm:col-span-2">
                        <x-input-field label="Address Line 2" model="company_address.line2" />
                    </div>

                    <x-input-field label="City" model="company_address.city" />
                    <x-input-field label="State / Region" model="company_address.state" />
                    <x-input-field label="Postal Code" model="company_address.postal_code" />
                    <x-input-field label="Country" model="company_address.country" />
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
