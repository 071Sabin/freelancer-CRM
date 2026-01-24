<div class="">

    <x-main-heading title="Clients" subtitle="Manage your business relationships and track client progress." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    {{-- calling error component from the component --}}
    {{-- <x-error></x-error> --}}

    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Clients</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $clientCount }}
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">All time</p>
        </div>

        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Active Projects</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                {{ $clientDetails->where('status', 'active')->count() }}</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Ongoing</p>
        </div>

        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Avg. Project Value</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                {{-- safe average: avoid division by zero --}}
                @php
                    $avg = $clientDetails->count()
                        ? number_format($clientDetails->avg('projects_value') ?? 0, 2)
                        : '0.00';
                @endphp
                ${{ $avg }}
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Per client</p>
        </div>

        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">New This Month</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">
                {{ $thisMonthClients }}</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">This month</p>
        </div>
    </div>



    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <flux:modal.trigger name="add-client">
            <x-primary-button>
                <i class="bi bi-plus-lg font-bold"></i> add client
            </x-primary-button>
        </flux:modal.trigger>
    </div>

    <div class="bg-white dark:bg-neutral-800 shadow-sm rounded-lg overflow-hidden">


        <x-clients.show-add-client-form />

        <livewire:clients.edit-client-form />

    </div>

    @if ($clientCount > 0)
        <div class="border-none">
            <livewire:clients.clients-table />
        </div>
    @else
        <div
            class="flex flex-col items-center justify-center py-12 px-4 border-2 border-dashed rounded-lg 
            border-neutral-300 bg-neutral-50 text-neutral-500 
            dark:border-neutral-700 dark:bg-transparent dark:text-neutral-400">

            <i class="bi bi-x-circle text-5xl mb-3"></i>

            <p class="text-neutral-600 dark:text-neutral-300 font-medium">
                No Clients are added!
            </p>
        </div>
    @endif

</div>
