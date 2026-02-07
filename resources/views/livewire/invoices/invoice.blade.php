<div class="">

    <x-main-heading title="Invoices" subtitle="Create, send, and track invoices with clear payment status and totals." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">

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
            <x-primary-button class="flex gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd"
                        d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z"
                        clip-rule="evenodd" />
                </svg>
                Create invoice
            </x-primary-button>
        </flux:modal.trigger>
        <a href="{{ route('invoices.settings.general') }}" wire:navigate
            class="text-zinc-500 hover:text-zinc-900 dark:hover:text-white">
            <flux:icon.cog-6-tooth />
        </a>
    </div>


    <div>

        <flux:modal name="create-invoice" class="max-w-lg">
            <form wire:submit.prevent="create" class="space-y-6">
                <div>
                    <flux:heading size="lg">Create New Invoice</flux:heading>
                    <flux:text class="text-neutral-500">
                        Start by selecting a client. You can add items in the next step.
                    </flux:text>
                    @if ($due_date_notice)
                        <p class="mt-2 text-xs text-yellow-500 dark:text-yellow-400">
                            {{ $due_date_notice }}
                        </p>
                    @endif
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
                    <flux:input type="date" label="Issue Date" wire:model.live="issue_date" />
                    <div>
                        <flux:input type="date" label="Due Date" wire:model.defer="due_date" />
                    </div>
                </div>

                <div class="flex justify-end gap-3">
                    <x-primary-button type="submit">
                        Create & Add Items
                    </x-primary-button>
                </div>
            </form>
        </flux:modal>

    </div>

    @if ($total_invoices == 0)
        <x-empty-state title="No Invoices Yet"
            subtitle="You haven't created any invoices yet. Start by creating a new invoice to manage your billing.">
            <x-slot:icon>
                <i class="bi bi-file-text text-2xl"></i>
            </x-slot:icon>
        </x-empty-state>
    @else
        <livewire:invoices.invoice-table />
    @endif

</div>
