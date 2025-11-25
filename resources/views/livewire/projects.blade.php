<div class="">

    <div class="mb-8">
        <x-main-heading title="Projects" subtitle="Add and manage your projects." />
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


    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 mb-8">
        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Total Projects</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">0
            </p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">All time</p>
        </div>

        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Active Projects</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">0</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Ongoing</p>
        </div>


        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">New This Month</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">0</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">This month</p>
        </div>
    </div>


    <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4">

        {{-- @if (count($projectDetails) > 0) --}}
            <div class="relative w-full sm:w-96">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <x-input-field type="text" placeholder="Search projects..." class="pl-10" />
            </div>
        {{-- @endif --}}
        <button onClick=""
            class="inline-flex items-center px-4 cursor-pointer py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-neutral-900 hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 w-full sm:w-auto justify-center">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Project
        </button>
    </div>


    <p
        class="text-neutral-400 bg-neutral-50/70 text-center dark:text-neutral-300 font-semibold text-sm dark:bg-neutral-600 rounded p-5 border-neutral-400 border">
        No Projects are added yet! Add one by clicking above!</p>
</div>
