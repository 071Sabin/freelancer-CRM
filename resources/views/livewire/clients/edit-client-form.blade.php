<div class="bg-none">
    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif
    @if ($open)
        <div class="modal fixed inset-0 z-99 bg-black/50 backdrop-blur-md overflow-y-auto px-4 py-6">

            <div class="min-h-full flex items-start justify-center">

                <form wire:submit="saveClientEdit" class="bg-white dark:bg-neutral-800 rounded-lg w-full max-w-3xl p-5">

                    <h1 class="text-xl font-bold flex justify-between">
                        Edit Client Details

                        <button wire:click="closeEdit" type="button"
                            class="text-neutral-400 hover:text-red-500 cursor-pointer">
                            <i class="bi bi-x-lg"></i>
                        </button>

                    </h1>

                    <x-hr-divider/>

                    <div class="lg:grid grid-cols-2 gap-3">
                        <!-- Row 1 -->
                        <x-input-field type="text" model="editClient.client_name" label="Client Name"
                            placeholder="Enter client name" required />
                        <x-input-field model="editClient.client_email" type="email" placeholder="Enter client email"
                            label="Client Email" required />
                        <x-input-field type="text" model="editClient.company_name" label="Company Name"
                            placeholder="Enter company name" />

                        <!-- Row 2 -->
                        <x-input-field type="email" model="editClient.company_email" label="Company Email"
                            placeholder="company@example.com" />

                        <x-input-field type="text" model="editClient.company_website" label="Company Website"
                            placeholder="https://example.com" />

                        <!-- Row 3 -->
                        <x-input-field type="text" model="editClient.company_phone" label="Company Phone"
                            placeholder="+1 555 555 5555" required />

                        <!-- Billing address (full width) -->
                        <x-input-field type="textarea" model="editClient.billing_address" label="Billing Address"
                            placeholder="Billing address..." class="col-span-2" required />

                        <!-- Hourly rate + Currency grouped -->
                        <div class="flex flex-col lg:flex-row gap-2">
                            <x-input-field type="number" model="editClient.hourly_rate" label="Hourly Rate"
                                placeholder="Hourly rate" required />

                            <div class="w-full">
                                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Currency
                                    <span class="text-red-500">*</span></label>
                                <select wire:model="editClient.currency"
                                    class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"
                                    required>
                                    <option value="" selected>-- Select --</option>
                                    <option value="usd">USD — $</option>
                                    <option value="eur">EUR — €</option>
                                    <option value="gbp">GBP — £</option>
                                    <option value="inr">INR — ₹</option>
                                </select>
                                @error('editClient.currency')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- System Status -->
                        <div>
                            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">System Status
                                <span class="text-red-500">*</span></label>
                            <select wire:model="editClient.status"
                                class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"
                                required>
                                <option value="" selected>-- Select Status --</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="lead">Lead</option>
                            </select>
                            @error('editClient.status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Private notes (full width) -->
                        <div class="col-span-2">
                            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Private
                                Notes</label>
                            <textarea wire:model="editClient.private_notes" placeholder="Private notes for yourself"
                                class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"></textarea>
                            @error('editClient.private_notes')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <x-primary-button type="submit">save</x-primary-button>
                <flux:text wire:dirty class="text-amber-500 text-sm font-medium animate-pulse">
                    Unsaved changes...
                </flux:text>
                </form>

            </div>
        </div>
    @elseif($showDetails)
        <div class="modal fixed inset-0 z-99 bg-black/50 backdrop-blur-md overflow-y-auto px-4 py-6">
            <div class="min-h-full flex items-start justify-center">
                <div
                    class="w-full max-w-3xl rounded-xl shadow-xl bg-white text-stone-800 border border-stone-200 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700">
                    {{-- Header --}}
                    <div
                        class="flex items-center justify-between px-6 py-4
                    border-b border-stone-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-stone-800 dark:text-neutral-100">
                            Client Details
                        </h2>

                        <button wire:click="closeView" class="text-neutral-400 hover:text-red-500 cursor-pointer"
                            aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-6 space-y-6">

                        {{-- Deleted Warning --}}
                        @if (!empty($viewClient['deleted_at']))
                            <div
                                class="rounded-md px-4 py-3 text-sm
                           bg-red-50 text-red-700 border border-red-300
                           dark:bg-red-900/30 dark:text-red-300 dark:border-red-500">
                                ⚠️ This client has been deleted.
                            </div>
                        @endif

                        {{-- Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Client
                                    Name</p>
                                <p class="mt-1 text-sm font-medium text-stone-800 dark:text-neutral-100">
                                    {{ $viewClient['client_name'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Company
                                    Name</p>
                                <p class="mt-1 text-sm font-medium text-stone-800 dark:text-neutral-100">
                                    {{ $viewClient['company_name'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Company
                                    Email</p>
                                <p class="mt-1 text-sm text-stone-700 dark:text-neutral-200">
                                    {{ $viewClient['company_email'] ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Phone
                                </p>
                                <p class="mt-1 text-sm text-stone-700 dark:text-neutral-200">
                                    {{ $viewClient['company_phone'] ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Website
                                </p>
                                <p class="mt-1 text-sm text-stone-700 dark:text-neutral-200">
                                    {{ $viewClient['company_website'] ?? '—' }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Billing
                                    Address</p>
                                <p class="mt-1 text-sm text-stone-700 dark:text-neutral-200">
                                    {{ $viewClient['billing_address'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Hourly
                                    Rate</p>
                                <p class="mt-1 text-sm font-medium text-stone-800 dark:text-neutral-100 uppercase">
                                    {{ $viewClient['currency'] }} {{ $viewClient['hourly_rate'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Status
                                </p>

                                @php
                                    $statusColors = [
                                        'active' => 'bg-green-100 text-green-700 border border-green-400
                                 dark:bg-green-900/30 dark:text-green-300 dark:border-green-500',

                                        'inactive' => 'bg-red-100 text-red-700 border border-red-400
                                 dark:bg-red-900/30 dark:text-red-300 dark:border-red-500',

                                        'lead' => 'bg-amber-100 text-amber-700 border border-amber-400
                                 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-500',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs font-semibold
                               {{ $statusColors[$viewClient['status']] ?? 'bg-stone-100 text-stone-700 dark:bg-neutral-700 dark:text-neutral-300' }}">
                                    {{ ucfirst($viewClient['status']) }}
                                </span>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Private
                                    Notes</p>
                                <p class="mt-1 text-sm text-stone-700 dark:text-neutral-200 whitespace-pre-line">
                                    {{ $viewClient['private_notes'] ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 border-t border-stone-200 dark:border-neutral-700 flex justify-end">
                        <x-secondary-button wire:click="$set('showDetails', false)">close</x-secondary-button>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
