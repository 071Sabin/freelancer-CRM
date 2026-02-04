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

    <form wire:submit.prevent="save">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-12">

            <div class="md:col-span-1">
                <flux:heading size="lg" class="mb-2">Defaults</flux:heading>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    These values will be automatically applied to new invoices to save you time. You can override them
                    on individual invoices.
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl">

                    <flux:input type="number" step="0.01" label="Default Tax Rate"
                        wire:model.defer="default_tax_rate" icon="percent-badge" placeholder="0.00" />

                    <flux:input type="number" label="Payment Terms (Days)" wire:model.defer="payment_terms_days"
                        description="Days until invoice is due." placeholder="14" />

                    <flux:input type="number" step="0.01" label="Default Discount Rate"
                        wire:model.defer="default_discount_rate" icon="percent-badge" placeholder="0.00" />

                    <div class="sm:col-span-2">
                        <flux:sidebar.toggle 
                            label="Allow Partial Payments" 
                            description="Let clients pay invoices in installments."
                            wire:model.defer="allow_partial_payments" 
                        />
                    </div>
                </div>
            </div>
        </div>

        <div class="my-10">
            <flux:separator variant="subtle" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-y-6 gap-x-12">
            <div class="md:col-span-1">
                <flux:heading size="lg" class="mb-2">Late Fees</flux:heading>
                <div class="text-sm text-zinc-500 dark:text-zinc-400 leading-relaxed">
                    Add penalties to overdue invoices.
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 max-w-2xl">
                    <flux:select label="Late Fee Type" wire:model.defer="default_late_fee_type" placeholder="Select type">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </flux:select>
                    <flux:input type="number" step="0.01" label="Late Fee Rate (%)"
                        wire:model.defer="default_late_fee_rate" placeholder="0.00" />

                    <flux:input type="number" step="0.01" label="Late Fee Amount"
                        wire:model.defer="default_late_fee_amount" placeholder="0.00" />
                </div>
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
