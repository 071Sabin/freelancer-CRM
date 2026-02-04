<div class="space-y-6">

    <x-main-heading title="Invoices" subtitle="Create, send, and track invoices with clear payment status and totals." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

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
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">

        <div class="flex items-center justify-end gap-3 w-full">
            <flux:modal.trigger name="create-invoice">
                <x-primary-button><i class="bi bi-plus-lg font-bold"></i> create invoice</x-primary-button>
            </flux:modal.trigger>
            <a href="{{ route('invoices.settings.general') }}" wire:navigate
                class="text-zinc-500 hover:text-zinc-900 dark:hover:text-white">
                <flux:icon.cog-6-tooth />
            </a>
        </div>
    </div>

    <div>

        <flux:modal name="create-invoice" class="max-w-lg">
            <form wire:submit.prevent="create" class="space-y-6">
                <div>
                    <flux:heading size="lg">Create New Invoice</flux:heading>
                    <flux:text class="text-neutral-500">
                        Start by selecting a client. You can add items in the next step.
                    </flux:text>
                </div>

                <flux:select label="Client" wire:model="client_id" placeholder="Select client">
                    @foreach ($clients as $client)
                        <flux:select.option value="{{ $client->id }}">
                            {{ $client->client_name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <flux:select label="Project" wire:model="project_id" placeholder="Select project">
                    @foreach ($projects as $project)
                        <flux:select.option value="{{ $project->id }}">
                            {{ $project->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>

                <div class="grid grid-cols-2 gap-4">
                    <flux:input type="date" label="Issue Date" wire:model.defer="issue_date" />
                    <flux:input type="date" label="Due Date" wire:model.defer="due_date" />
                </div>

                <div class="flex justify-end gap-3">
                    <x-primary-button type="submit">
                        Create & Add Items
                    </x-primary-button>
                </div>
            </form>
        </flux:modal>

    </div>

    {{-- <livewire:invoices.invoice-table /> --}}

</div>
