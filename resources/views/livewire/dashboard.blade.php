<div class="w-full">

    <x-main-heading title="Dashboard 👋" subtitle="Overview of your clients, projects, invoices, and insights." />


    <!-- KPI Cards -->
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

        <x-dashboard-card heading="Total Clients" value="{{ $totalClients }}" dataOverTime="+3 new this month"
            icon='
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                </svg>'>
        </x-dashboard-card>

        <!-- Projects -->
        <x-dashboard-card heading="Active Projects" value="{{ $activeProjects }}"
            dataOverTime="{{ $progressProjects }} in progress"
            icon='
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z" />
            </svg>'
            dataColor="text-blue-500 dark:text-blue-400">
        </x-dashboard-card>

        <!-- Revenue -->
        <x-dashboard-card heading="Total Revenue" value="$0" dataOverTime="+12% growth"
            icon='
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>'>
        </x-dashboard-card>

        <!-- Invoices -->
        <x-dashboard-card heading="Pending Invoices" value="3" dataOverTime="1 overdue"
            icon='
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 3.75h.008v.008H12v-.008Z" />
                </svg>'
            dataColor="text-yellow-600 dark:text-yellow-500">
        </x-dashboard-card>

    </div>

    {{-- Two-Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{--  Recent Projects --}}
        <div
            class="lg:col-span-2 flex flex-col h-full bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700/50 rounded-xl shadow-sm overflow-hidden">

            <div
                class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-700/50 flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-neutral-400 dark:text-neutral-500" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                    </svg>
                    <h2 class="text-base font-semibold text-neutral-900 dark:text-white">
                        Recent Projects
                    </h2>
                </div>
                <a href="{{ route('projects') }}" wire:navigate
                    class="text-xs font-medium text-neutral-500 hover:text-indigo-600 dark:text-neutral-400 dark:hover:text-white transition-colors">
                    View All &rarr;
                </a>
            </div>

            <div class="flex-1 overflow-y-auto">
                <ul class="divide-y divide-neutral-100 dark:divide-neutral-700/50">
                    @foreach ($recentProjects as $rp)
                        <li class="group relative">
                            <a href="#"
                                class="flex items-center justify-between p-4 sm:px-6 hover:bg-neutral-50 dark:hover:bg-neutral-700/40 transition-colors duration-200">

                                <div class="flex items-center gap-4 min-w-0">
                                    <div
                                        class="hidden sm:flex h-10 w-10 flex-none items-center justify-center rounded-lg bg-neutral-100 dark:bg-neutral-700/50 border border-neutral-200 dark:border-neutral-600 text-neutral-500 dark:text-neutral-400 group-hover:bg-white dark:group-hover:bg-neutral-700 transition-colors">
                                        <span class="text-xs font-bold uppercase">
                                            {{ substr($rp->name, 0, 2) }}
                                        </span>
                                    </div>

                                    <div class="min-w-0 flex-auto">
                                        <p
                                            class="text-sm font-semibold text-neutral-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                            {{ $rp->name }}
                                        </p>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <svg class="w-3 h-3 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                            </svg>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">
                                                {{ $rp->client->client_name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    @php
                                        // Ring/Badge Style Configuration
                                        $statusConfig = match ($rp->status) {
                                            'active' => [
                                                'classes' =>
                                                    'bg-blue-50 text-blue-700 ring-blue-600/20 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/20',
                                                'dot' => 'bg-blue-600 dark:bg-blue-400',
                                            ],
                                            'in-progress' => [
                                                'classes' =>
                                                    'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/20',
                                                'dot' => 'bg-amber-600 dark:bg-amber-400',
                                            ],
                                            'on-hold' => [
                                                'classes' =>
                                                    'bg-neutral-50 text-neutral-600 ring-neutral-500/10 dark:bg-neutral-400/10 dark:text-neutral-400 dark:ring-neutral-400/20',
                                                'dot' => 'bg-neutral-500 dark:bg-neutral-400',
                                            ],
                                            'completed' => [
                                                'classes' =>
                                                    'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/20',
                                                'dot' => 'bg-emerald-600 dark:bg-emerald-400',
                                            ],
                                            'cancelled' => [
                                                'classes' =>
                                                    'bg-rose-50 text-rose-700 ring-rose-600/20 dark:bg-rose-400/10 dark:text-rose-400 dark:ring-rose-400/20',
                                                'dot' => 'bg-rose-600 dark:bg-rose-400',
                                            ],
                                            default => [
                                                'classes' =>
                                                    'bg-neutral-50 text-neutral-600 ring-neutral-500/10 dark:bg-neutral-400/10 dark:text-neutral-400 dark:ring-neutral-400/20',
                                                'dot' => 'bg-neutral-500 dark:bg-neutral-400',
                                            ],
                                        };
                                    @endphp

                                    <div
                                        class="inline-flex items-center rounded-md px-2 py-1 text-xs font-medium ring-1 ring-inset {{ $statusConfig['classes'] }}">
                                        <span class="mr-1.5 h-1.5 w-1.5 rounded-full {{ $statusConfig['dot'] }}"></span>
                                        <span class="capitalize">{{ str_replace('-', ' ', $rp->status) }}</span>
                                    </div>

                                    <svg class="h-5 w-5 flex-none text-neutral-400 group-hover:text-neutral-600 dark:group-hover:text-white transition-colors"
                                        viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd"
                                            d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            @if (count($recentProjects) > 5)
                <div
                    class="bg-neutral-50 dark:bg-neutral-900/30 border-t border-neutral-100 dark:border-neutral-700/50 px-6 py-3">
                    <p class="text-xs text-center text-neutral-500 dark:text-neutral-400">Showing 5 latest projects</p>
                </div>
            @endif
        </div>


        {{-- Quick Actions --}}
        <div
            class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 rounded-xl shadow-sm overflow-hidden flex flex-col h-full">

            <div
                class="px-5 py-4 border-b border-neutral-100 dark:border-neutral-800 flex justify-between items-center bg-neutral-50/50 dark:bg-stone-800">
                <h2 class="text-sm font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                    <svg class="w-4 h-4 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Quick Actions
                </h2>
            </div>

            <div class="flex-1 divide-y divide-neutral-100 dark:divide-neutral-800">

                <a href="{{ route('projects') }}" wire:navigate
                    class="group flex items-center justify-between p-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors duration-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-lg bg-indigo-50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-500/10 flex items-center justify-center text-indigo-600 dark:text-indigo-400 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p
                                class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                Create Project</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Start a new workflow</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-neutral-300 dark:text-neutral-600 group-hover:text-neutral-500 dark:group-hover:text-neutral-300 transform group-hover:translate-x-1 transition-all"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('clients') }}" wire:navigate
                    class="group flex items-center justify-between p-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors duration-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center text-neutral-600 dark:text-neutral-300 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                            </svg>
                        </div>
                        <div>
                            <p
                                class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 group-hover:text-neutral-700 dark:group-hover:text-white transition-colors">
                                Add Client</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Onboard new customer</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-neutral-300 dark:text-neutral-600 group-hover:text-neutral-500 dark:group-hover:text-neutral-300 transform group-hover:translate-x-1 transition-all"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>

                <a href="{{ route('invoices') }}" wire:navigate
                    class="group flex items-center justify-between p-4 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 transition-colors duration-200">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-lg bg-neutral-100 dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 flex items-center justify-center text-neutral-600 dark:text-neutral-300 group-hover:scale-110 transition-transform duration-200">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p
                                class="text-sm font-semibold text-neutral-900 dark:text-neutral-100 group-hover:text-neutral-700 dark:group-hover:text-white transition-colors">
                                Draft Invoice</p>
                            <p class="text-xs text-neutral-500 dark:text-neutral-400">Bill for your work</p>
                        </div>
                    </div>
                    <svg class="w-5 h-5 text-neutral-300 dark:text-neutral-600 group-hover:text-neutral-500 dark:group-hover:text-neutral-300 transform group-hover:translate-x-1 transition-all"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </div>
        </div>

    </div>

</div>
