<div class="">

    <div class="mb-8">
        <x-main-heading title="Clients" subtitle="Manage your business relationships and track client progress." />
        <p class="text-sm italic text-red-400 dark:text-red-600">Refresh to activate "Add Client" form</p>
    </div>

    @if (session('success'))
        <div class="mb-6">
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        </div>
    @endif

    {{-- calling error component from the component --}}
    <x-error></x-error>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Clients</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                {{ count($clientDetails) }}
            </p>
        </div>
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Active Projects</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                {{ $clientDetails->where('status', 'active')->count() }}
            </p>
        </div>
        {{-- <div
                class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
                <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Pending Invoices</p>
                <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                    3
                </p>
            </div> --}}
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">

        @if (count($clientDetails) > 0)
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <x-input-field type="text" placeholder="Search clients..." class="pl-10" />
            </div>
        @endif
        <button onClick="showAddClientForm()"
            class="inline-flex items-center px-4 cursor-pointer py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neutral-900 hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 w-full sm:w-auto justify-center">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Client
        </button>
    </div>

    <div
        class="bg-white dark:bg-neutral-800 shadow-sm border border-neutral-200 dark:border-neutral-700 rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            @if (count($clientDetails) > 0)
                <table class="min-w-full divide-y divide-neutral-200 dark:divide-neutral-700">
                    <thead class="bg-neutral-50 dark:bg-neutral-700/50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Client Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Company</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Status</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Created At</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">
                                Hourly Rate</th>
                            <th scope="col" class="px-6 py-3">
                                <span
                                    class="px-6 py-3 text-left text-xs font-medium text-neutral-500 dark:text-neutral-400 uppercase tracking-wider">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-neutral-800 divide-y divide-neutral-200 dark:divide-neutral-700">
                        @foreach ($clientDetails as $client)
                            <tr class="hover:bg-neutral-50 dark:hover:bg-neutral-700/50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <i class="bi bi-person-circle"></i>
                                        <div class="ml-4">
                                            <div
                                                class="text-sm font-medium text-neutral-900 dark:text-neutral-100 capitalize">
                                                {{ $client->client_name }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-neutral-900 dark:text-neutral-100 capitalize">
                                        {{ $client->company_name }}
                                    </div>
                                    <div class="text-sm text-neutral-500 dark:text-neutral-400">
                                        {{ $client->company_email }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusClasses = [
                                            'active' =>
                                                'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 border-green-200 dark:border-green-800',
                                            'inactive' =>
                                                'bg-red-100 text-red-800 dark:bg-red-900/30 dark:text-red-300 border-red-200 dark:border-red-800',
                                            'lead' =>
                                                'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
                                        ];
                                    @endphp

                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full border
        {{ $statusClasses[$client->status] ?? 'bg-neutral-200 text-neutral-800 dark:bg-neutral-700 dark:text-neutral-300 border-neutral-300 dark:border-neutral-600' }}">
                                        {{ ucfirst($client->status) }}
                                    </span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ $client->created_at->diffForHumans() }}
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500 dark:text-neutral-400">
                                    {{ Str::upper($client->currency) }} {{ $client->hourly_rate }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">

                                    <button wire:click="openEdit({{ $client->id }})"
                                        class="text-neutral-600 cursor-pointer hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100 mr-3">Edit</button>
                                    <button wire:click="delete({{ $client->id }})"
                                        class="text-neutral-600 hover:text-neutral-900 dark:text-neutral-400 dark:hover:text-neutral-100 cursor-pointer">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p
                    class="text-neutral-400 bg-neutral-50/70 text-center dark:text-neutral-300 font-semibold text-sm dark:bg-neutral-600 rounded p-5 border-neutral-400 border">
                    No Clients are added yet! Add one by clicking above!</p>
            @endif
        </div>

        <div id="addClientForm"
            class="hidden border border-white fixed top-0 left-0 bg-black/50 backdrop-blur-md w-full h-full flex flex-wrap items-center justify-center">
            <div class="bg-white dark:bg-neutral-800 rounded-lg w-1/2 p-5">
                <div class="flex justify-between">
                    <h3 class="text-xl font-semibold">Add New Client</h3>
                    <button onclick="showAddClientForm()" class="">
                        <i
                            class="bi bi-x-lg block text-neutral-500 hover:text-red-500 font-semibold cursor-pointer"></i>
                    </button>
                </div>
                <hr class="mt-5 text-neutral-300 dark:text-neutral-700">
                <div class="grid grid-cols-2 gap-3 my-6">
                    <x-input-field model="clientname" type="text" placeholder="Enter client name" label="Client Name"
                        required />
                    <x-input-field model="companyname" type="text" placeholder="Enter company name"
                        label="Company Name" required />

                    <x-input-field model="companyemail" type="email" placeholder="Company email"
                        label="Company Email" />

                    <x-input-field model="website" type="text" placeholder="Company website"
                        label="Company Website" />

                    <x-input-field model="companyphone" type="text" placeholder="Company phone"
                        label="Company Phone" required />

                    <x-input-field model="billing_address" type="textarea" placeholder="Billing Address...."
                        label="Billing Address" required />


                    <div class="flex flex-col lg:flex-row gap-2">
                        <x-input-field model="hrate" type="number" placeholder="Hourly rate" label="Hourly Rate"
                            required />
                        <div>
                            <label for="" class="text-gray-800 dark:text-neutral-400 text-sm">Currency <span
                                    class="text-red-500">*</span></label>
                            <select wire:model="currency" id=""
                                class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150">
                                <option value="" selected>-- Select --</option>
                                <option value="usd">USD — $</option>
                                <option value="eur">EUR — €</option>
                                <option value="gbp">GBP — £</option>
                                <option value="inr">INR — ₹</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="" class="text-gray-800 dark:text-neutral-400 text-sm">System
                            Status <span class="text-red-500">*</span></label>
                        <select wire:model="status" id="" required
                            class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150">
                            <option value="" selected>-- Select Status --</option>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="lead">Lead</option>
                        </select>
                    </div>
                    <div class=" col-span-2">
                        <label for="" class="text-gray-800 dark:text-neutral-400 text-sm">Private
                            Notes</label>
                        <textarea placeholder="Private notes for yourself" wire:model="privatenote"
                            class="w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150"></textarea>
                    </div>

                </div>
                <div class="flex justify-between gap-6">
                    <button class="bg-blue-500 w-1/2 text-white rounded px-3 py-2 hover:bg-blue-600 cursor-pointer"
                        wire:click="addClient">Add Client</button>
                    <button
                        class="bg-neutral-500 w-1/2 text-white hover:bg-neutral-600 px-3 py-2 rounded cursor-pointer"
                        onclick="showAddClientForm()">Cancel</button>
                </div>
            </div>
        </div>

        @if ($showEditModal)
            <div
                class="modal border border-white fixed top-0 left-0 bg-black/50 backdrop-blur-md w-full h-full flex flex-wrap items-center justify-center">
                <form wire:submit="saveClientEdit" class="bg-white dark:bg-neutral-800 rounded-lg w-1/2 p-5">
                    <h1 class="text-xl font-bold flex justify-between">Edit Client Details
                        <button wire:click="closeEdit" type="button">
                            <i class="bi bi-x-lg text-red-500 cursor-pointer"></i>
                        </button>
                    </h1>
                    <hr class="text-neutral-300 dark:bg-neutral-700 my-5">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-3">
                        <!-- Row 1 -->
                        <x-input-field type="text" model="editClient.client_name" label="Client Name"
                            placeholder="Enter client name" required />

                        <x-input-field type="text" model="editClient.company_name" label="Company Name"
                            placeholder="Enter company name" required />

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

                    <button type="submit"
                        class="bg-blue-500 px-3 py-2 rounded hover:bg-blue-600 cursor-pointer mt-5">Save</button>
                </form>
            </div>
        @endif


    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            window.showAddClientForm = function() {
                const form = document.getElementById('addClientForm');
                if (form.classList.contains('hidden')) {
                    form.classList.remove('hidden');
                } else {
                    form.classList.add('hidden');
                }
            }
        });
    </script>
</div>
