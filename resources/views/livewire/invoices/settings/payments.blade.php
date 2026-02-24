<div class="space-y-10 pb-10">
    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif
    <div>
        <flux:heading size="xl">Payment Settings</flux:heading>
        <flux:subheading>
            Control tax rates, terms, and how you collect payments.
        </flux:subheading>
    </div>

    <flux:separator variant="subtle" />

    <form wire:submit.prevent="save" class="space-y-12">

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-1">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Invoice Defaults</h3>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                    These values will be automatically applied to new invoices to save you time. You can override them
                    on individual invoices.
                </p>
            </div>

            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <div class="space-y-1">
                        <x-input-field type="number" step="0.01" label="Default Tax Rate (%)"
                            model="default_tax_rate" placeholder="0.00" />
                    </div>

                    <div class="space-y-1">
                        <x-input-field type="number" label="Payment Terms (Days)" model="default_due_days"
                            placeholder="14" />
                    </div>

                    <div class="space-y-1">
                        <x-input-field type="number" step="0.01" label="Default Discount Rate (%)"
                            model="default_discount_rate" placeholder="0.00" />
                    </div>

                    <div
                        class="sm:col-span-2 flex items-center justify-between p-4 bg-neutral-50 dark:bg-neutral-800/50 rounded-lg border border-neutral-100 dark:border-neutral-800">
                        <div>
                            <span class="block text-sm font-medium text-neutral-900 dark:text-white">Allow Partial
                                Payments</span>
                            <span class="block text-xs text-neutral-500 dark:text-neutral-400">Let clients pay invoices
                                in installments.</span>
                        </div>
                        <button type="button" wire:click="$toggle('allow_partial_payments')"
                            class="relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2 {{ $allow_partial_payments ? 'bg-indigo-600' : 'bg-neutral-200 dark:bg-neutral-700' }}"
                            role="switch" aria-checked="{{ $allow_partial_payments ? 'true' : 'false' }}">
                            <span aria-hidden="true"
                                class="pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out {{ $allow_partial_payments ? 'translate-x-5' : 'translate-x-0' }}"></span>
                        </button>
                    </div>

                </div>
            </div>
        </div>

        <div class="border-t border-neutral-200 dark:border-neutral-800"></div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">
            <div class="lg:col-span-1">
                <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Late Fees</h3>
                <p class="mt-2 text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed">
                    Automatically add penalties to invoices that are past their due date.
                </p>
            </div>

            <div
                class="lg:col-span-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 rounded-xl p-6 shadow-sm">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <flux:select wire:model.defer="default_late_fee_type" label="Late Fee Type"
                        placeholder="Select type...">
                        <flux:select.option value="percentage">Percentage (%)</flux:select.option>
                        <flux:select.option value="fixed">Fixed Amount ($)</flux:select.option>
                    </flux:select>

                    @if ($default_late_fee_type === 'percentage')
                        <x-input-field type="number" step="0.01" label="Late Fee Rate (%)"
                            model="default_late_fee_rate" placeholder="5.00" />
                    @elseif($default_late_fee_type === 'fixed')
                        <x-input-field type="number" step="0.01" label="Late Fee Amount"
                            model="default_late_fee_amount" placeholder="50.00" />
                    @else
                        <div class="hidden sm:block"></div>
                    @endif
                </div>

                @if (!$default_late_fee_type)
                    <p class="mt-4 text-xs text-neutral-400 dark:text-neutral-500 italic">Select a fee type to configure
                        rates.</p>
                @endif
            </div>
        </div>

        <div class="mt-16 pt-6 flex justify-end border-t border-zinc-100 dark:border-zinc-800">
            <div class="flex items-center gap-4">
                <flux:text wire:dirty class="text-amber-500 text-sm font-medium">
                    Unsaved changes...
                </flux:text>
                <x-primary-button type="submit">Save Payments</x-primary-button>
            </div>
        </div>

    </form>
</div>
