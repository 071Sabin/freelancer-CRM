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
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $projectCount }}</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">All time</p>
        </div>

        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">Active Projects</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $progressProjects }}</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">Ongoing</p>
        </div>


        <div
            class="p-6 bg-white dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700 shadow-sm">
            <p class="text-sm font-medium text-neutral-500 dark:text-neutral-400">New This Month</p>
            <p class="mt-2 text-3xl font-bold text-neutral-900 dark:text-neutral-100">{{ $thisMonthProjects }}</p>
            <p class="mt-1 text-xs text-neutral-500 dark:text-neutral-400">This month</p>
        </div>
    </div>


    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <flux:modal.trigger name="add-project">
            <x-primary-button>
                <i class="bi bi-plus-lg font-bold"></i> Add Project
            </x-primary-button>
        </flux:modal.trigger>
    </div>


    <x-projects.show-add-project-form :clients="$clients" />

    <livewire:projects.edit-project-form />


    @if ($projectCount > 0)
        <livewire:projects.projects-table />
    @else
        <div
            class="flex flex-col items-center justify-center py-12 px-4 border-2 border-dashed rounded-lg 
            border-neutral-300 bg-neutral-50 text-neutral-500 
            dark:border-neutral-700 dark:bg-transparent dark:text-neutral-400">

            <i class="bi bi-x-circle text-5xl mb-3"></i>

            <p class="text-neutral-600 dark:text-neutral-300 font-medium">
                No Projects are added!
            </p>
        </div>
    @endif
</div>
