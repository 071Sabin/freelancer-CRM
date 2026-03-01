@props(['currencies', 'form'])


<flux:modal name="add-client-modal" class="w-full max-w-2xl !p-0 bg-white shadow-2xl rounded-2xl dark:bg-neutral-800">

    <div wire:loading wire:target="edit"
        class="absolute inset-0 z-10 flex items-center justify-center bg-white/80 dark:bg-neutral-900/80 backdrop-blur-sm rounded-2xl">
        <flux:icon.loading class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
    </div>

    <div wire:loading.remove wire:target="edit">
        {{-- Check if the form object has a loaded client --}}
        @if (!$form->client)
            {{-- calling update function because in Clients.php this single function handles the update/create clients. even add/edit client form is the same for both edit/create client both --}}
            <form wire:submit.prevent="addClient" class="flex flex-col max-h-[90vh]">

<div class="flex flex-col gap-4 px-6 pt-6 pb-5 border-b sm:flex-row sm:items-start sm:px-8 border-neutral-200 dark:border-neutral-700">
    
    {{-- Professional Icon Badge --}}
    <div class="flex items-center justify-center shrink-0 w-12 h-12 bg-indigo-50 border rounded-xl shadow-sm border-indigo-100 text-indigo-600 dark:bg-indigo-500/10 dark:border-indigo-500/20 dark:text-indigo-400">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
        </svg>
    </div>

    {{-- Typography & Context --}}
    <div class="flex flex-col justify-center min-h-[3rem]">
        {{-- Breadcrumb Context --}}
        <div class="flex items-center gap-2 mb-1 text-sm font-medium text-neutral-500 dark:text-neutral-400">
            <span>Clients</span>
            <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
            <span class="text-indigo-600 dark:text-indigo-400">Add New</span>
        </div>
        
        {{-- Main Heading (Scaled down to xl so it doesn't break mobile) --}}
        <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white leading-none">
            Add Client
        </flux:heading>
    </div>
</div>

                <div class="px-6 py-6 overflow-y-auto sm:px-8 space-y-8">

                    <div>
                        <h3 class="mb-4 text-sm font-semibold text-neutral-900 dark:text-white">Contact Details
                        </h3>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            {{-- Updated models to form.attribute --}}
                            <x-input-field label="Client Name" model="form.client_name" placeholder="Enter client name"
                                required />
                            <x-input-field label="Client Email" type="email" model="form.client_email"
                                placeholder="Enter client email" required />
                        </div>
                    </div>

                    <x-hr-divider />

                    <div>
                        <h3 class="mb-4 text-sm font-semibold text-neutral-900 dark:text-white">Company Information
                        </h3>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                            <x-input-field label="Company Name" model="form.company_name"
                                placeholder="Enter company name" />
                            <x-input-field label="Company Email" type="email" model="form.company_email"
                                placeholder="Enter company email" />
                            <x-input-field label="Website" model="form.company_website"
                                placeholder="Enter website URL" />
                            <x-input-field label="Phone" model="form.company_phone" placeholder="Enter phone number" />
                        </div>
                    </div>

                    <x-hr-divider />

                    <div>
                        <h3 class="mb-4 text-sm font-semibold text-neutral-900 dark:text-white">Billing & Status
                        </h3>
                        <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                            <flux:select wire:model="form.currency_id" label="Currency" searchable>
                                @foreach ($currencies as $currency)
                                    <flux:select.option value="{{ $currency->id }}">
                                        {{ $currency->code }} — {{ $currency->symbol }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>

                            <x-input-field label="Hourly Rate" type="number" step="0.01" model="form.hourly_rate"
                                placeholder="0.00" />

                            <flux:select wire:model="form.status" label="Status" placeholder="Status...">
                                <flux:select.option value="active">Active</flux:select.option>
                                <flux:select.option value="inactive">Inactive</flux:select.option>
                                <flux:select.option value="lead">Lead</flux:select.option>
                            </flux:select>
                        </div>
                    </div>

                    <x-hr-divider />

                    <div class="space-y-5">
                        <flux:textarea label="Billing Address" placeholder="Billing Address"
                            wire:model="form.billing_address" />
                        <flux:textarea label="Private Notes" placeholder="Private notes for yourself"
                            wire:model="form.private_notes" />
                    </div>
                </div>

                <div
                    class="flex items-center justify-end gap-3 px-6 py-4 bg-neutral-50 sm:px-8 border-t border-neutral-200 rounded-b-2xl dark:bg-neutral-900/50 dark:border-neutral-800">
                    <flux:modal.close>
                        <x-secondary-button>Cancel</x-secondary-button>
                    </flux:modal.close>
                    
                    <x-primary-button type="submit">Save changes</x-primary-button>
                </div>

            </form>
        @else
            <div class="flex flex-col items-center justify-center p-12 text-center">
                <div
                    class="flex items-center justify-center w-12 h-12 mb-4 bg-neutral-100 rounded-full dark:bg-neutral-800">
                    <svg class="w-6 h-6 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <h3 class="text-sm font-semibold text-neutral-900 dark:text-white">No Client Selected</h3>
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Please select a client from the
                    table to edit their details.</p>
            </div>
        @endif
    </div>
</flux:modal>
