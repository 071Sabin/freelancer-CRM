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
    {{-- <x-error></x-error> --}}


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


    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <button wire:click="showAddProjectsForm"
            class="inline-flex items-center px-4 cursor-pointer py-2 rounded-md shadow-sm text-sm font-medium text-white bg-neutral-900 hover:bg-neutral-700 dark:bg-neutral-100 dark:text-neutral-900 dark:hover:bg-neutral-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 w-full sm:w-auto justify-center">
            <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Project
        </button>
    </div>

    @if ($showAddProjects)
        <x-projects.show-add-project-form :clients="$clients" />
    @endif





    <div
        class="flex flex-col items-center justify-center py-12 px-4 border-2 border-dashed rounded-lg 
            border-neutral-300 bg-neutral-50 text-neutral-500 
            dark:border-neutral-700 dark:bg-transparent dark:text-neutral-400">

        <i class="bi bi-x-circle text-5xl mb-3"></i>

        <p class="text-neutral-600 dark:text-neutral-300 font-medium">
            No Projects are added!
        </p>
    </div>
</div>
