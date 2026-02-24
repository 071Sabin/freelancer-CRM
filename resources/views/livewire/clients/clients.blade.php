<div class="">

    <x-main-heading title="Clients" subtitle="Manage your business relationships and track client progress." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    {{-- calling error component from the component --}}
    {{-- <x-error></x-error> --}}

    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

        <x-dashboard-card heading="Total Clients" :value="$clientCount" dataOverTime="Lifetime base"
            icon='
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>'
            dataColor="text-neutral-400 dark:text-neutral-500" />

        <x-dashboard-card heading="Active Retainers" :value="$clientDetails->where('status', 'active')->count()" dataOverTime="Ongoing"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z"/></svg>'
            dataColor="text-emerald-600 dark:text-emerald-500" />

        @php $avg = $clientDetails->count() ? number_format($clientDetails->avg('projects_value') ?? 0,2) : '0.00'; @endphp
        <x-dashboard-card heading="Avg. Revenue" :value="'$' . $avg" dataOverTime="Per client engagement"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>'
            dataColor="text-neutral-400 dark:text-neutral-500" />

        <x-dashboard-card heading="Acquisition" :value="$thisMonthClients" dataOverTime="Joined this month"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>'
            dataColor="text-neutral-400 dark:text-neutral-500" />
    </div>


    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <flux:modal.trigger name="add-client">
            <x-primary-button class="flex gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path
                        d="M5.25 6.375a4.125 4.125 0 1 1 8.25 0 4.125 4.125 0 0 1-8.25 0ZM2.25 19.125a7.125 7.125 0 0 1 14.25 0v.003l-.001.119a.75.75 0 0 1-.363.63 13.067 13.067 0 0 1-6.761 1.873c-2.472 0-4.786-.684-6.76-1.873a.75.75 0 0 1-.364-.63l-.001-.122ZM18.75 7.5a.75.75 0 0 0-1.5 0v2.25H15a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H21a.75.75 0 0 0 0-1.5h-2.25V7.5Z" />
                </svg>
                add client
            </x-primary-button>
        </flux:modal.trigger>
    </div>

    <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg overflow-hidden">
        <x-clients.show-add-client-form :currencies="$currencies" />
    </div>

    {{-- CLIENTS DATATABLE --}}
    @if ($clientCount > 0)
        <div class="border-none">
            <livewire:clients.clients-table />
        </div>
    @else
        <x-empty-state title="No Clients Yet" subtitle="Add a client to start creating invoices and projects.">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                </svg>

            </x-slot:icon>
        </x-empty-state>
    @endif



    {{-- View Client Modal --}}
    <flux:modal name="view-client-modal"
        class="w-full max-w-xl !p-0 bg-white shadow-2xl rounded-2xl dark:bg-neutral-900">

        <div wire:loading wire:target="view"
            class="absolute inset-0 z-10 flex items-center justify-center bg-white/80 dark:bg-neutral-900/80 backdrop-blur-sm rounded-2xl">
            <flux:icon.loading class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
        </div>

        <div wire:loading.remove wire:target="view" class="w-full flex flex-col max-h-[90vh]">
            @if (!empty($viewingClient))
                @php
                    // Modern "Badge" styling with Ring utilities
                    $statusHtml = match (ucfirst($viewingClient['status'] ?? '')) {
                        'Active'
                            => '<span class="inline-flex items-center rounded-md bg-green-50 px-2.5 py-1 text-xs font-medium text-green-700 ring-1 ring-inset ring-green-600/20 dark:bg-green-500/10 dark:text-green-400 dark:ring-green-500/20">Active</span>',
                        'Inactive'
                            => '<span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20">Inactive</span>',
                        'Lead'
                            => '<span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-500 dark:ring-amber-400/20">Lead</span>',
                        default
                            => '<span class="inline-flex items-center rounded-md bg-neutral-50 px-2.5 py-1 text-xs font-medium text-neutral-600 ring-1 ring-inset ring-neutral-500/10 dark:bg-neutral-400/10 dark:text-neutral-400 dark:ring-neutral-400/20">Unknown</span>',
                    };
                @endphp

                <div
                    class="flex items-start justify-between px-6 pt-6 pb-5 border-b sm:px-8 border-neutral-200 dark:border-neutral-800 shrink-0">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center justify-center shrink-0 w-14 h-14 text-xl font-bold bg-neutral-900 text-white rounded-xl shadow-sm dark:bg-white dark:text-neutral-900 ring-1 ring-black/5 dark:ring-white/10">
                            {{ substr($viewingClient['client_name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <flux:heading size="xl" level="2" class="text-neutral-900 dark:text-white">
                                    {{ $viewingClient['client_name'] }}
                                </flux:heading>
                                <div>{!! $statusHtml !!}</div>
                            </div>
                            @if ($viewingClient['company_name'])
                                <div
                                    class="flex items-center gap-1.5 mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path d="M3 21l18 0" />
                                        <path d="M5 21l0 -14l8 -4l8 4l0 14" />
                                        <path d="M9 10l0 0.01" />
                                        <path d="M9 13l0 0.01" />
                                        <path d="M9 16l0 0.01" />
                                        <path d="M15 10l0 0.01" />
                                        <path d="M15 13l0 0.01" />
                                        <path d="M15 16l0 0.01" />
                                    </svg>
                                    <span>{{ $viewingClient['company_name'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6 overflow-y-auto sm:px-8 sm:py-8">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-6 sm:gap-y-8">

                        <div class="flex flex-col gap-1">
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Email Address</dt>
                            <dd class="text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $viewingClient['client_email'] ?? '—' }}
                            </dd>
                        </div>

                        <div class="flex flex-col gap-1">
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Company Email</dt>
                            <dd class="text-sm text-neutral-900 dark:text-neutral-100">
                                {{ $viewingClient['company_email'] ?? '—' }}
                            </dd>
                        </div>

                        <div class="flex flex-col gap-1">
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Phone Number</dt>
                            <dd class="text-sm text-neutral-900 dark:text-neutral-100 tabular-nums">
                                {{ $viewingClient['company_phone'] ?? '—' }}
                            </dd>
                        </div>

                        <div class="flex flex-col gap-1">
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Website</dt>
                            <dd class="text-sm">
                                @if ($viewingClient['company_website'])
                                    <a href="{{ str_starts_with($viewingClient['company_website'], 'http') ? $viewingClient['company_website'] : 'https://' . $viewingClient['company_website'] }}"
                                        target="_blank" rel="noopener noreferrer"
                                        class="inline-flex items-center gap-1.5 text-indigo-600 hover:text-indigo-700 dark:text-indigo-400 dark:hover:text-indigo-300 transition-colors">
                                        {{ str_replace(['https://', 'http://', 'www.'], '', $viewingClient['company_website']) }}
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                            class="w-3.5 h-3.5">
                                            <path fill-rule="evenodd"
                                                d="M4.25 5.5a.75.75 0 0 0-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 0 0 .75-.75v-4a.75.75 0 0 1 1.5 0v4A2.25 2.25 0 0 1 12.75 17h-8.5A2.25 2.25 0 0 1 2 14.75v-8.5A2.25 2.25 0 0 1 4.25 4h5a.75.75 0 0 1 0 1.5h-5Z"
                                                clip-rule="evenodd" />
                                            <path fill-rule="evenodd"
                                                d="M6.194 12.753a.75.75 0 0 0 1.06.053L16.5 4.44v2.81a.75.75 0 0 0 1.5 0v-4.5a.75.75 0 0 0-.75-.75h-4.5a.75.75 0 0 0 0 1.5h2.553l-9.056 8.194a.75.75 0 0 0-.053 1.06Z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                @else
                                    <span class="text-neutral-400">—</span>
                                @endif
                            </dd>
                        </div>

                        <div class="flex flex-col gap-1 sm:col-span-2">
                            <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Hourly Rate</dt>
                            <dd class="text-base font-semibold text-neutral-900 dark:text-white tabular-nums">
                                <span
                                    class="text-neutral-500 uppercase text-xs mr-1">{{ $viewingClient['currency']['code'] ?? 'USD' }}</span>
                                {{ number_format($viewingClient['hourly_rate'], 2) }}
                            </dd>
                        </div>

                        @if (!empty($viewingClient['billing_address']))
                            <div class="flex flex-col gap-2 sm:col-span-2 pt-2">
                                <dt class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Billing Address
                                </dt>
                                <dd
                                    class="p-4 text-sm leading-relaxed rounded-xl bg-neutral-50 dark:bg-white/5 text-neutral-700 dark:text-neutral-300 ring-1 ring-inset ring-neutral-200 dark:ring-white/10">
                                    {!! nl2br(e($viewingClient['billing_address'])) !!}
                                </dd>
                            </div>
                        @endif
                    </dl>

                    @if (!empty($viewingClient['private_notes']))
                        <div class="mt-4">
                            <div
                                class="p-4 rounded-xl bg-amber-50 dark:bg-amber-900/20 ring-1 ring-inset ring-amber-200/50 dark:ring-amber-700/30">
                                <div class="flex gap-3">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                        class="w-5 h-5 mt-0.5 shrink-0 text-amber-600 dark:text-amber-500">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 1 1-16 0 8 8 0 0 1 16 0ZM8.94 6.94a.75.75 0 1 1-1.061-1.061 3 3 0 1 1 2.871 5.026v.345a.75.75 0 0 1-1.5 0v-.5c0-.72.57-1.172 1.081-1.287A1.5 1.5 0 1 0 8.94 6.94ZM10 15a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    <div>
                                        <h4 class="text-sm font-semibold text-amber-800 dark:text-amber-500">Private
                                            Notes</h4>
                                        <p
                                            class="mt-1 text-sm leading-relaxed text-amber-900/80 dark:text-amber-200/80">
                                            {!! nl2br(e($viewingClient['private_notes'])) !!}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <div
                    class="flex items-center justify-end px-6 py-4 bg-neutral-50 sm:px-8 border-t border-neutral-200 rounded-b-2xl dark:bg-neutral-900/50 dark:border-neutral-800 shrink-0">
                    <flux:modal.close>
                        <x-secondary-button>close</x-secondary-button>
                    </flux:modal.close>
                </div>
            @else
                <div class="flex flex-col items-center justify-center p-16 text-center">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-neutral-100 dark:bg-neutral-800">
                        <svg class="w-6 h-6 text-neutral-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-white">No Client Selected</h3>
                    <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Select a client from the list to
                        view their details.</p>
                    <button type="button" x-on:click="$modal.close('view-client-modal')"
                        class="mt-6 text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                        Go back
                    </button>
                </div>
            @endif
        </div>
    </flux:modal>

    {{-- Edit Client Modal --}}
    <flux:modal name="edit-client-modal"
        class="w-full max-w-3xl !p-0 bg-white shadow-2xl rounded-2xl dark:bg-neutral-900">

        <div wire:loading wire:target="edit"
            class="absolute inset-0 z-10 flex items-center justify-center bg-white/80 dark:bg-neutral-900/80 backdrop-blur-sm rounded-2xl">
            <flux:icon.loading class="w-8 h-8 text-indigo-600 dark:text-indigo-400" />
        </div>

        <div wire:loading.remove wire:target="edit">
            @if (!empty($editingClient))
                <form wire:submit.prevent="update" class="flex flex-col max-h-[90vh]">

                    <div
                        class="flex items-start gap-4 px-6 pt-6 pb-5 border-b sm:px-8 border-neutral-200 dark:border-neutral-700">
                        <div
                            class="flex items-center justify-center shrink-0 w-12 h-12 text-lg font-semibold bg-white border rounded-xl shadow-sm text-neutral-600 border-neutral-200 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300">
                            {{ substr($editingClient['client_name'] ?? 'C', 0, 1) }}
                        </div>
                        <div>
                            <div
                                class="flex items-center gap-2 mb-1 text-sm font-medium text-neutral-500 dark:text-neutral-400">
                                <span>Clients</span>
                                <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="text-indigo-600 dark:text-indigo-400">Edit Profile</span>
                            </div>
                            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">
                                {{ $editingClient['client_name'] }}
                            </flux:heading>
                        </div>
                    </div>

                    <div class="px-6 py-6 overflow-y-auto sm:px-8 space-y-8">

                        <div>
                            <h3 class="mb-4 text-sm font-semibold text-neutral-900 dark:text-white">Contact Details
                            </h3>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <x-input-field label="Client Name" model="editingClient.client_name" required />
                                <x-input-field label="Client Email" type="email" model="editingClient.client_email"
                                    required />
                            </div>
                        </div>

                        <x-hr-divider />

                        <div>
                            <h3 class="mb-4 text-sm font-semibold text-neutral-900 dark:text-white">Company Information
                            </h3>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                                <x-input-field label="Company Name" model="editingClient.company_name" />
                                <x-input-field label="Company Email" type="email"
                                    model="editingClient.company_email" />
                                <x-input-field label="Website" model="editingClient.company_website" />
                                <x-input-field label="Phone" model="editingClient.company_phone" />
                            </div>
                        </div>

                        <x-hr-divider />

                        <div>
                            <h3 class="mb-4 text-sm font-semibold text-neutral-900 dark:text-white">Billing & Status
                            </h3>
                            <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

                                <div class="w-full group">
                                    <label
                                        class="block text-sm font-medium leading-6 text-neutral-900 transition-colors duration-200 dark:text-neutral-300">Currency</label>
                                    <div class="relative">
                                        <select wire:model="editingClient.currency_id"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-base sm:text-sm leading-6 text-neutral-900 bg-white shadow-sm ring-1 ring-inset ring-neutral-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-shadow duration-200 ease-in-out dark:bg-neutral-900 dark:text-white dark:ring-neutral-700 dark:focus:ring-indigo-500">
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">{{ $currency->code }} —
                                                    {{ $currency->symbol }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('editingClient.currency.code')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <x-input-field label="Hourly Rate" type="number" step="0.01"
                                    model="editingClient.hourly_rate" />

                                <div class="w-full group">
                                    <label
                                        class="block text-sm font-medium leading-6 text-neutral-900 transition-colors duration-200 dark:text-neutral-300">Status</label>
                                    <div class="relative mt-1">
                                        <select wire:model="editingClient.status"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-base sm:text-sm leading-6 text-neutral-900 bg-white shadow-sm ring-1 ring-inset ring-neutral-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 transition-shadow duration-200 ease-in-out dark:bg-neutral-900 dark:text-white dark:ring-neutral-700 dark:focus:ring-indigo-500">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="lead">Lead</option>
                                        </select>
                                    </div>
                                    @error('editingClient.status')
                                        <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <x-hr-divider />

                        <div class="space-y-5">
                            <x-textarea-field label="Billing Address" model="editingClient.billing_address"
                                rows="3" />
                            <x-textarea-field label="Private Notes" model="editingClient.private_notes"
                                rows="3" />
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
                        <svg class="w-6 h-6 text-neutral-400" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
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
</div>
