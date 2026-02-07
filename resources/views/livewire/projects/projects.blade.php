<div class="">


    <x-main-heading title="Projects" subtitle="Add and manage your projects." />


    @if (session('success'))
        <div class="mb-6">
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        </div>
    @endif

    {{-- calling error component from the component --}}
    {{-- <x-error></x-error> --}}


    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-5 gap-4 lg:gap-5 mb-10">

        <div
            class="group relative p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 transition-all duration-300 hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        Total Lifecycle</p>
                    <div class="text-neutral-400 group-hover:text-indigo-500 transition-colors duration-300">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m9 9 6-6m0 0 6 6m-6-6v12a6 6 0 0 1-12 0v-3" />
                        </svg>


                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        {{ $projectCount }}</h3>
                    <p class="mt-1 text-xs font-medium text-neutral-400 dark:text-neutral-500">All-time volume</p>
                </div>
            </div>
        </div>

        <div
            class="group relative p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 transition-all duration-300 hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        In Progress</p>
                    <div class="text-neutral-400 group-hover:text-emerald-500 transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        {{ $progressProjects }}</h3>
                    <p
                        class="mt-1 text-xs font-semibold text-emerald-600 dark:text-emerald-500 flex items-center gap-1">
                        <span class="w-1 h-1 rounded-full bg-emerald-500 animate-pulse"></span> Ongoing
                    </p>
                </div>
            </div>
        </div>

        <div
            class="group relative p-5 bg-white dark:bg-neutral-800 rounded-2xl border border-neutral-200 dark:border-neutral-700 transition-all duration-300 hover:border-neutral-300 dark:hover:border-neutral-600 shadow-sm">
            <div class="flex flex-col gap-3">
                <div class="flex items-center justify-between">
                    <p class="text-[11px] font-bold uppercase tracking-[0.05em] text-neutral-400 dark:text-neutral-500">
                        New Growth</p>
                    <div class="text-neutral-400 group-hover:text-violet-500 transition-colors duration-300">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </div>
                </div>
                <div>
                    <h3
                        class="text-2xl lg:text-3xl font-extrabold tracking-tight text-neutral-900 dark:text-neutral-100">
                        {{ $thisMonthProjects }}</h3>
                    <p class="mt-1 text-xs font-medium text-violet-600 dark:text-violet-400 flex items-center gap-1">
                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-8.707l-3-3a1-1 0 00-1.414 0l-3 3a1-1 0 001.414 1.414L9 9.414V13a1-1 0 102 0V9.414l1.293 1.293a1-1 0 001.414-1.414z"
                                clip-rule="evenodd" />
                        </svg>
                        This month
                    </p>
                </div>
            </div>
        </div>

    </div>


    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
        <flux:modal.trigger name="add-project">
            <x-primary-button class="flex gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd"
                        d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z"
                        clip-rule="evenodd" />
                </svg>
                Add Project
            </x-primary-button>
        </flux:modal.trigger>
    </div>


    <x-projects.show-add-project-form :clients="$clients" />

    <livewire:projects.edit-project-form />


    @if ($projectCount > 0)
        <livewire:projects.projects-table />
    @else
        <x-empty-state title="No Projects Yet" subtitle="Create your first project to start managing work.">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>

            </x-slot:icon>
        </x-empty-state>
    @endif
</div>
