<div class="">

    <x-main-heading title="Clients" subtitle="Manage your business relationships and track client progress." />

    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif

    {{-- calling error component from the component --}}
    {{-- <x-error></x-error> --}}

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-5 mb-10">

        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 transition-all duration-300 hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Total Clients</p>
                    <div class="text-neutral-400 group-hover:text-indigo-500 transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        {{ $clientCount }}</h3>
                    <p class="mt-1 text-xs font-medium text-neutral-400 dark:text-neutral-500">Lifetime base</p>
                </div>
            </div>
        </div>

        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 transition-all duration-300 hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Active Retainers</p>
                    <div class="text-neutral-400 group-hover:text-emerald-500 transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 13.5l10.5-11.25L12 10.5h8.25L9.75 21.75 12 13.5H3.75z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        {{ $clientDetails->where('status', 'active')->count() }}
                    </h3>
                    <p
                        class="mt-1 text-xs font-semibold text-emerald-600 dark:text-emerald-500 flex items-center gap-1">
                        <span class="w-1 h-1 rounded-full bg-emerald-500"></span> Ongoing
                    </p>
                </div>
            </div>
        </div>

        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 transition-all duration-300 hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Avg. Revenue</p>
                    <div
                        class="text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <div>
                    @php
                        $avg = $clientDetails->count()
                            ? number_format($clientDetails->avg('projects_value') ?? 0, 2)
                            : '0.00';
                    @endphp
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100 tabular-nums">
                        ${{ $avg }}
                    </h3>
                    <p class="mt-1 text-xs font-medium text-neutral-400 dark:text-neutral-500 text-nowrap">Per client
                        engagement</p>
                </div>
            </div>
        </div>

        <div
            class="relative overflow-hidden group p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 transition-all duration-300 hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Acquisition</p>
                    <div class="text-neutral-400 group-hover:text-indigo-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        {{ $thisMonthClients }}</h3>
                    <p class="mt-1 text-xs font-medium text-neutral-400 dark:text-neutral-500">Joined this month</p>
                </div>
            </div>
        </div>

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

        <livewire:clients.edit-client-form />

    </div>

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

</div>
