<div class="w-full">

    <!-- Page Header -->
    <div class="mb-8">
        <x-main-heading title="Dashboard 👋" subtitle="Overview of your clients, projects, invoices, and insights." />
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">

        <x-dashboard-card heading="Total Clients" value="{{ $totalClients }}" dataOverTime="+3 new this month"
            icon='<i class="bi bi-people text-gray-400 text-lg"></i>'>
        </x-dashboard-card>

        <!-- Projects -->
        <x-dashboard-card heading="Active Projects" value="{{ $activeProjects }}"
            dataOverTime="{{ $progressProjects }} in progress" icon='<i class="bi bi-kanban text-gray-400 text-lg"></i>'
            dataColor="text-blue-500">
        </x-dashboard-card>

        <!-- Revenue -->
        <x-dashboard-card heading="Total Revenue" value="$0" dataOverTime="+12% growth"
            icon='<i class="bi bi-currency-dollar text-gray-400 text-lg"></i>'>
        </x-dashboard-card>

        <!-- Invoices -->
        <x-dashboard-card heading="Pending Invoices" value="3" dataOverTime="1 overdue"
            icon='<i class="bi bi-receipt text-gray-400 text-lg"></i>' dataColor="text-yellow-600">
        </x-dashboard-card>

    </div>

    <!-- Two-Column Layout -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Recent Projects -->
        <div
            class="lg:col-span-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 
                    rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                Recent Projects
            </h2>

            <div class="divide-y divide-neutral-200 dark:divide-neutral-700">
                @foreach ($recentProjects as $rp)
                    <div class="py-4 flex items-center justify-between">
                        <div>
                            <p class="font-medium text-gray-800 dark:text-gray-100 capitalize">{{ $rp->name }}</p>
                            <p class="text-sm text-gray-500 dark:text-gray-400 capitalize">Client:
                                {{ $rp->client->client_name }}</p>
                        </div>

                        {{-- this php is to set the recent projects status colors, in dashboard --}}
                        @php
                            $statusClasses = match ($rp->status) {
                                'active' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
                                'in-progress' => 'bg-amber-100 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
                                'on-hold' => 'bg-gray-100 text-gray-700 dark:bg-gray-900/30 dark:text-gray-300',
                                'completed' => 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300',
                                'cancelled' => 'bg-rose-100 text-rose-700 dark:bg-rose-900/30 dark:text-rose-300',
                                default => 'bg-gray-100 text-gray-500 dark:bg-gray-900 dark:text-gray-400',
                            };
                        @endphp
                        <span class="px-2.5 py-1 rounded text-xs font-semibold capitalize {{ $statusClasses }}">
                            {{ str_replace('-', ' ', $rp->status) }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        
        


        <!-- Quick Actions -->
        <div
            class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 
                    rounded-xl p-6 shadow-sm">
            <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">
                Quick Actions
            </h2>

            <div class="flex flex-col gap-3">
                <a href="{{ route('projects') }}" wire:navigate class="px-4 py-2 bg-indigo-600 text-white text-center rounded-lg hover:bg-indigo-700">
                    + New Project
                </a>
                <a href="{{ route('clients') }}" wire:navigate
                    class="px-4 py-2 bg-neutral-200 text-neutral-900 dark:bg-neutral-700 dark:text-neutral-100 
                                   text-center rounded-lg hover:bg-neutral-300 dark:hover:bg-neutral-600">
                    + New Client
                </a>
                <a href="#" wire:navigate
                    class="px-4 py-2 bg-neutral-100 dark:bg-gray-700 text-center rounded-lg 
                                   hover:bg-neutral-200 dark:hover:bg-gray-800 text-neutral-800 dark:text-neutral-200">
                    Generate Invoice
                </a>
            </div>
        </div>

    </div>

</div>
