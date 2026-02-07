<div class="">

    <x-main-heading title="Invoices" subtitle="Create, send, and track invoices with clear payment status and totals." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-5 mb-10">

        <!-- Total Invoices -->
        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700  hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Total Invoices
                    </p>
                    <div class="text-neutral-400 group-hover:text-indigo-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m3.75 9v7.5m2.25-6.466a9.016 9.016 0 0 0-3.461-.203c-.536.072-.974.478-1.021 1.017a4.559 4.559 0 0 0-.018.402c0 .464.336.844.775.994l2.95 1.012c.44.15.775.53.775.994 0 .136-.006.27-.018.402-.047.539-.485.945-1.021 1.017a9.077 9.077 0 0 1-3.461-.203M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>

                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        0</h3>
                    <p class="mt-1 text-xs font-medium text-neutral-400 dark:text-neutral-500">All time</p>
                </div>
            </div>
        </div>

        <!-- Paid Invoices -->
        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700  hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Paid Invoices
                    </p>
                    <div class="text-neutral-400 group-hover:text-emerald-500 transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        0</h3>
                    <p class="mt-1 text-xs font-medium text-neutral-400 dark:text-neutral-500">Successfully paid</p>
                </div>
            </div>
        </div>

        <!-- Outstanding Amount -->
        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700  hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Outstanding
                    </p>
                    <div class="text-neutral-400 group-hover:text-amber-500 transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-3h6" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        $0.00</h3>
                    <p class="mt-1 text-xs font-medium text-neutral-400 dark:text-neutral-500">Awaiting payment</p>
                </div>
            </div>
        </div>

        <!-- Overdue -->
        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700  hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Overdue
                    </p>
                    <div class="text-neutral-400 group-hover:text-red-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                        </svg>

                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        0</h3>
                    <p class="mt-1 text-xs font-medium text-red-500">Past due date</p>
                </div>
            </div>
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
