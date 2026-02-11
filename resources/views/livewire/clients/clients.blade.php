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


        <x-clients.show-add-client-form />

        {{-- this component will view and edit the client details --}}
        {{-- <livewire:clients.edit-client-form /> --}}

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
        class="min-h-[600px] min-w-[600px] md:min-w-[800px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="view">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="view">
                @if (!empty($viewingClient))
                    <div class="space-y-6">
                        <div class="flex justify-between items-start">
                            <div>
                                <flux:heading size="xl">{{ $viewingClient['client_name'] }}</flux:heading>
                                <flux:text>{{ $viewingClient['company_name'] }}</flux:text>
                            </div>
                            <div class="text-right">
                                <flux:badge size="lg"
                                    :color="$viewingClient['status'] === 'active' ? 'green' : 'zinc'">
                                    {{ ucfirst($viewingClient['status']) }}
                                </flux:badge>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <flux:label>Email</flux:label>
                                <div class="font-medium">{{ $viewingClient['client_email'] }}</div>
                            </div>
                            <div>
                                <flux:label>Company Email</flux:label>
                                <div class="font-medium">{{ $viewingClient['company_email'] }}</div>
                            </div>
                            <div>
                                <flux:label>Phone</flux:label>
                                <div>{{ $viewingClient['company_phone'] }}</div>
                            </div>
                            <div>
                                <flux:label>Website</flux:label>
                                <div><a href="{{ $viewingClient['company_website'] }}" target="_blank"
                                        class="text-blue-500 hover:underline">{{ $viewingClient['company_website'] }}</a>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <flux:label>Billing Address</flux:label>
                                <div>{{ $viewingClient['billing_address'] }}</div>
                            </div>
                            <div>
                                <flux:label>Hourly Rate</flux:label>
                                <div>{{ $viewingClient['currency'] }} {{ $viewingClient['hourly_rate'] }}</div>
                            </div>
                        </div>

                        @if ($viewingClient['private_notes'])
                            <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4">
                                <flux:label>Private Notes</flux:label>
                                <p class="text-neutral-600 dark:text-neutral-400">{{ $viewingClient['private_notes'] }}
                                </p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="text-center text-neutral-500">No client selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>

    {{-- Edit Client Modal --}}
    <flux:modal name="edit-client-modal" class="min-h-[600px] md:min-w-[800px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="edit">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="edit">
                @if (!empty($editingClient))
                    <div class="space-y-6">
                        <flux:heading size="lg">Edit Client: {{ $editingClient['client_name'] }}</flux:heading>

                        <form wire:submit.prevent="update" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-input-field label="Client Name" model="editingClient.client_name" required />
                                <x-input-field label="Client Email" type="email" model="editingClient.client_email"
                                    required />

                                <x-input-field label="Company Name" model="editingClient.company_name" />
                                <x-input-field label="Company Email" type="email"
                                    model="editingClient.company_email" />

                                <x-input-field label="Website" model="editingClient.company_website" />
                                <x-input-field label="Phone" model="editingClient.company_phone" />

                                <x-input-field label="Hourly Rate" type="number" step="0.01"
                                    model="editingClient.hourly_rate" />
                                <x-input-field label="Currency" model="editingClient.currency" />

                                <div class="w-full group">
                                    <label
                                        class="block text-sm font-medium leading-6 text-neutral-900 dark:text-white transition-colors duration-200">Status</label>
                                    <div class="mt-2 relative">
                                        <select wire:model="editingClient.status"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-neutral-900 dark:text-white bg-white dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 text-base sm:text-sm sm:leading-6 transition-shadow duration-200 ease-in-out">
                                            <option value="active">Active</option>
                                            <option value="inactive">Inactive</option>
                                            <option value="lead">Lead</option>
                                        </select>
                                        @error('editingClient.status')
                                            <div
                                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                                                <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20"
                                                    fill="currentColor">
                                                    <path fill-rule="evenodd"
                                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                                                        clip-rule="evenodd" />
                                                </svg>
                                            </div>
                                        @enderror
                                    </div>
                                    @error('editingClient.status')
                                        <p class="mt-2 text-xs text-red-600 dark:text-red-400 animate-pulse">
                                            {{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="w-full group">
                                <label
                                    class="block text-sm font-medium leading-6 text-neutral-900 dark:text-white transition-colors duration-200">Billing
                                    Address</label>
                                <div class="mt-2 relative">
                                    <textarea wire:model="editingClient.billing_address" rows="3"
                                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-neutral-900 dark:text-white bg-white dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 placeholder:text-neutral-400 dark:placeholder:text-neutral-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 text-base sm:text-sm sm:leading-6 transition-shadow duration-200 ease-in-out"></textarea>
                                </div>
                                @error('editingClient.billing_address')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400 animate-pulse">
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="w-full group">
                                <label
                                    class="block text-sm font-medium leading-6 text-neutral-900 dark:text-white transition-colors duration-200">Private
                                    Notes</label>
                                <div class="mt-2 relative">
                                    <textarea wire:model="editingClient.private_notes" rows="3"
                                        class="block w-full rounded-lg border-0 py-2.5 px-3 text-neutral-900 dark:text-white bg-white dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 placeholder:text-neutral-400 dark:placeholder:text-neutral-500 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 text-base sm:text-sm sm:leading-6 transition-shadow duration-200 ease-in-out"></textarea>
                                </div>
                                @error('editingClient.private_notes')
                                    <p class="mt-2 text-xs text-red-600 dark:text-red-400 animate-pulse">
                                        {{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex justify-end gap-3 pt-6">
                                <x-primary-button type="submit">Save changes</x-primary-button>
                            </div>
                        </form>


                    </div>
                @else
                    <div class="text-center text-neutral-500">No client selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>



</div>
