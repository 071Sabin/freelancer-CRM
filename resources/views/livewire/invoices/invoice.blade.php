<div class="">

    <div class="mb-8">
        <x-main-heading title="Invoices"
            subtitle="Create, send, and track invoices with clear payment status and totals." />
        {{-- <p class="text-sm italic text-red-400 dark:text-red-600">Refresh to activate "Add Client" form</p> --}}
    </div>

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    {{-- calling error component from the component --}}
    {{-- <x-error></x-error> --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">

        <!-- Total Invoices -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Total Invoices
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                0
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                All time
            </p>
        </div>

        <!-- Paid Invoices -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Paid Invoices
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                0
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Successfully paid
            </p>
        </div>

        <!-- Outstanding Amount -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Outstanding Amount
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                $0.00
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Awaiting payment
            </p>
        </div>

        <!-- Overdue Invoices -->
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">
                Overdue Invoices
            </p>
            <p class="mt-2 text-3xl font-semibold text-neutral-900 dark:text-neutral-100">
                0
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">
                Past due date
            </p>
        </div>

    </div>
    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <flux:modal.trigger name="create-invoice">
            <x-primary-button><i class="bi bi-plus-lg font-bold"></i> create invoice</x-primary-button>
        </flux:modal.trigger>
        <flux:modal.trigger name="invoice-settings">
            <flux:icon.cog-6-tooth />
        </flux:modal.trigger>
    </div>

    <flux:modal name="invoice-settings" id="invoice-settings">
        <div class="flex w-full">

            <!-- Sidebar -->
            <flux:sidebar.nav class="mt-5">
                <flux:sidebar.item icon="document-text" current>Invoice Settings</flux:sidebar.item>
                <flux:sidebar.item icon="currency-dollar">Payments</flux:sidebar.item>
                <flux:sidebar.item icon="paint-brush">Branding</flux:sidebar.item>
            </flux:sidebar.nav>

            <flux:separator vertical class="mx-1" />

            <!-- Main Content -->
            <flux:main class="max-w-4xl m-0 p-0">

                <flux:heading size="lg" level="1">
                    Invoice Settings
                </flux:heading>

                <flux:text class="mt-2 mb-6 text-sm text-neutral-500">
                    Configure default values used when creating new invoices.
                </flux:text>

                <flux:separator variant="subtle" class="mb-6 " />

                <!-- Invoice Numbering -->
                <div class="space-y-4 mb-8">
                    <flux:heading size="md">Invoice Numbering</flux:heading>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <flux:input label="Invoice Prefix" placeholder="INV" />

                        <flux:input type="number" label="Next Invoice Number"
                            helper="Used for the next invoice only" />
                    </div>
                </div>

                <!-- Defaults -->
                <div class="space-y-4 mb-8">
                    <flux:heading size="md">Defaults</flux:heading>

                    <flux:input label="Default Currency" placeholder="USD" />

                    <flux:input type="number" step="0.01" label="Default Tax Rate (%)" placeholder="18"
                        helper="Pre-filled when creating new invoices" />
                </div>

                <!-- Terms & Notes -->
                <div class="space-y-4 mb-8">
                    <flux:heading size="md">Invoice Text</flux:heading>

                    <flux:textarea label="Default Terms" rows="3" placeholder="Payment is due within 14 days." />

                    <flux:textarea label="Default Notes" rows="3" placeholder="Thank you for your business." />
                </div>

                <!-- Branding -->
                <div class="space-y-4 mb-10">
                    <flux:heading size="md">Branding</flux:heading>

                    <flux:input type="file" label="Invoice Logo" helper="Displayed on invoice PDFs" />
                </div>

                <!-- Actions -->
                <div class="flex justify-end gap-3">
                    <x-primary-button>Save Settings</x-primary-button>
                </div>

            </flux:main>
        </div>

    </flux:modal>


    <flux:modal name="create-invoice" class="max-w-lg">

        <form wire:submit.prevent="create" class="space-y-6">

            <div>
                <flux:heading size="lg">Create Invoice</flux:heading>
                <flux:text class="text-neutral-500">
                    Create a draft invoice to start adding items and taxes.
                </flux:text>
            </div>

            <flux:select label="Client" wire:model="client_id" placeholder="Select client">
                @foreach (\App\Models\Client::all() as $client)
                    <flux:select.option value="{{ $client->id }}">
                        {{ $client->client_name }}
                    </flux:select.option>
                @endforeach
            </flux:select>

            <flux:select label="Project" wire:model="project_id" placeholder="Select project">
                @foreach (\App\Models\Project::all() as $project)
                    <option value="{{ $project->id }}">
                        {{ $project->name }}
                    </option>
                @endforeach
            </flux:select>

            <flux:input type="date" label="Issue Date" wire:model.defer="issue_date" />

            <flux:input type="date" label="Due Date" wire:model.defer="due_date" />

            <div class="flex justify-end gap-3">
                <x-primary-button type="submit">create invoice</x-primary-button>
            </div>
        </form>
    </flux:modal>


    <table class="min-w-full border border-neutral-300 dark:border-neutral-700">
        <thead class="bg-neutral-100 dark:bg-neutral-800">
            <tr class="text-left text-sm font-semibold text-neutral-700 dark:text-neutral-300">
                <th class="px-4 py-2">Invoice #</th>
                <th class="px-4 py-2">Client</th>
                <th class="px-4 py-2">Project</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Issue Date</th>
                <th class="px-4 py-2">Due Date</th>
                <th class="px-4 py-2 text-right">Subtotal</th>
                <th class="px-4 py-2 text-right">Tax</th>
                <th class="px-4 py-2 text-right">Discount</th>
                <th class="px-4 py-2 text-right">Total</th>
            </tr>
        </thead>

        <tbody class="divide-y divide-neutral-200 dark:divide-neutral-700 text-sm">
            {{-- @forelse ($invoices as $invoice)
                <tr>
                    <td class="px-4 py-2 font-medium">
                        {{ $invoice->invoice_number }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $invoice->client->name ?? '—' }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $invoice->project->name ?? '—' }}
                    </td>

                    <td class="px-4 py-2 capitalize">
                        {{ $invoice->status }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $invoice->issue_date->format('Y-m-d') }}
                    </td>

                    <td class="px-4 py-2">
                        {{ $invoice->due_date->format('Y-m-d') }}
                    </td>

                    <td class="px-4 py-2 text-right">
                        {{ number_format($invoice->subtotal, 2) }} {{ strtoupper($invoice->currency) }}
                    </td>

                    <td class="px-4 py-2 text-right">
                        {{ number_format($invoice->tax_total, 2) }}
                    </td>

                    <td class="px-4 py-2 text-right">
                        {{ number_format($invoice->discount_total, 2) }}
                    </td>

                    <td class="px-4 py-2 text-right font-semibold">
                        {{ number_format($invoice->total, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="px-4 py-6 text-center text-neutral-500">
                        No invoices found.
                    </td>
                </tr>
            @endforelse --}}
        </tbody>
    </table>




</div>
