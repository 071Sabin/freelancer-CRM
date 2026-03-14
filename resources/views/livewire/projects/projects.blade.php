<div class="">

    <x-main-heading title="Projects" subtitle="Add and manage your projects." />

    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif


    {{-- PROJECT CARDS --}}
    <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-5 gap-6 mb-10">

        <x-dashboard-card heading="Total Lifecycle" :value="$projectCount" dataOverTime="All-time volume"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4"><path stroke-linecap="round" stroke-linejoin="round" d="m9 9 6-6m0 0 6 6m-6-6v12a6 6 0 0 1-12 0v-3"/></svg>'
            dataColor="text-neutral-400 dark:text-neutral-500" />

        <x-dashboard-card heading="In Progress" :value="$progressProjects" dataOverTime="Ongoing"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99"/></svg>'
            dataColor="text-emerald-600 dark:text-emerald-500" />

        <x-dashboard-card heading="New Growth" :value="$thisMonthProjects" dataOverTime="This month"
            icon='<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/></svg>'
            dataColor="text-violet-600 dark:text-violet-400" />

    </div>

    {{-- ADD PROJECT BUTTON --}}
    <div class="flex flex-col sm:flex-row justify-end items-center my-3 gap-4">
            <x-primary-button class="flex gap-1" wire:click="$dispatchTo('projects.project-form-modal', 'open-project-modal')">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path fill-rule="evenodd"
                        d="M19.5 21a3 3 0 0 0 3-3V9a3 3 0 0 0-3-3h-5.379a.75.75 0 0 1-.53-.22L11.47 3.66A2.25 2.25 0 0 0 9.879 3H4.5a3 3 0 0 0-3 3v12a3 3 0 0 0 3 3h15Zm-6.75-10.5a.75.75 0 0 0-1.5 0v2.25H9a.75.75 0 0 0 0 1.5h2.25v2.25a.75.75 0 0 0 1.5 0v-2.25H15a.75.75 0 0 0 0-1.5h-2.25V10.5Z"
                        clip-rule="evenodd" />
                </svg>
                add project
            </x-primary-button>
    </div>


    {{-- ADD & EDIT PROJECT FORM COMPONENT --}}
    <livewire:projects.project-form-modal />


    @if ($projectCount > 0)
        <livewire:projects.projects-table lazy />

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


    {{-- DELETE ONE PROJECT, IT'S FOR EACH ROW MODAL --}}
    <flux:modal name="delete-project-modal" class="min-w-[22rem]">
        <form wire:submit="delete" class="flex flex-col gap-4 sm:gap-5">
            <div class="flex items-start gap-3 sm:gap-4">
                <div
                    class="flex-shrink-0 flex items-center justify-center w-10 h-10 rounded-full bg-red-100 dark:bg-red-500/20">
                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                    </svg>
                </div>
                <div class="pt-0.5">
                    <flux:heading size="md" class="text-gray-900 dark:text-white font-semibold">Delete project
                    </flux:heading>
                    <flux:text class="mt-0.5 text-sm text-gray-500 dark:text-gray-400">
                        Are you sure? This will permanently erase all project data.
                    </flux:text>
                </div>
            </div>

            <div class="flex flex-col gap-3">
                <div
                    class="px-3 py-2.5 rounded-lg bg-gray-50 dark:bg-zinc-800/50 border border-gray-200 dark:border-zinc-700/50">
                    <div class="flex flex-col text-sm">
                        <div class="flex items-center justify-between pb-2">
                            <span class="text-gray-500 dark:text-gray-400">Project</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white truncate max-w-[150px] sm:max-w-[200px]">{{ $deleteProjectName }}</span>
                        </div>
                        <div
                            class="flex items-center justify-between pt-2 border-t border-gray-200 dark:border-zinc-700/50">
                            <span class="text-gray-500 dark:text-gray-400">Client</span>
                            <span
                                class="font-medium text-gray-900 dark:text-white truncate max-w-[150px] sm:max-w-[200px]">{{ $deleteClientName }}</span>
                        </div>
                    </div>
                </div>

                <div
                    class="px-3 py-2 rounded-md bg-red-50 dark:bg-red-500/10 border border-red-200 dark:border-red-500/20">
                    <flux:text class="text-xs sm:text-sm text-red-700 dark:text-red-400 flex items-center gap-2">
                        <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495zM10 5a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0110 5zm0 9a1 1 0 100-2 1 1 0 000 2z"
                                clip-rule="evenodd" />
                        </svg>
                        <span><strong class="font-medium">Warning:</strong> This action cannot be undone.</span>
                    </flux:text>
                </div>
            </div>

            <div class="flex items-center justify-end gap-2 sm:gap-3 pt-1">
                <flux:modal.close>
                    <flux:button variant="ghost"
                        class="text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white transition-colors">
                        Cancel
                    </flux:button>
                </flux:modal.close>
                <flux:button type="submit" variant="danger" class="w-full sm:w-auto shadow-sm">
                    Delete Project
                </flux:button>
            </div>
        </form>
    </flux:modal>
</div>
