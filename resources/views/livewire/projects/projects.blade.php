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


    {{-- ADD PROJECT FORM COMPONENT --}}
    <x-projects.show-add-project-form :clients="$clients" />


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

    {{-- View Project Modal --}}
    <flux:modal name="view-project-modal" class="min-h-[600px] w-full md:min-w-[600px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="view">
                <div class="flex justify-center py-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="view" class="w-full">
                @if (!empty($viewingProject))
                    @php
                        $statusHtml = match ($viewingProject['status']) {
                            'active'
                                => '<span class="inline-flex items-center rounded-md bg-blue-50 px-2 py-0.5 text-xs font-semibold text-blue-700 ring-1 ring-inset ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/20">Active</span>',
                            'in-progress'
                                => '<span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-0.5 text-xs font-semibold text-amber-800 ring-1 ring-inset ring-amber-700/10 dark:bg-amber-400/10 dark:text-amber-500 dark:ring-amber-400/20">In Progress</span>',
                            'completed'
                                => '<span class="inline-flex items-center rounded-md bg-emerald-50 px-2 py-0.5 text-xs font-semibold text-emerald-700 ring-1 ring-inset ring-emerald-700/10 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/20">Completed</span>',
                            'cancelled'
                                => '<span class="inline-flex items-center rounded-md bg-red-50 px-2 py-0.5 text-xs font-semibold text-red-700 ring-1 ring-inset ring-red-700/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20">Cancelled</span>',
                            default
                                => '<span class="inline-flex items-center rounded-md bg-neutral-100 px-2 py-0.5 text-xs font-semibold text-neutral-600 ring-1 ring-inset ring-neutral-500/10 dark:bg-neutral-800 dark:text-neutral-400 dark:ring-neutral-700">' .
                                ucfirst($viewingProject['status'] ?? 'Unknown') .
                                '</span>',
                        };
                    @endphp

                    <div class="relative">
                        <div class="px-4 pb-6 pt-2">
                            <div class="flex items-center gap-4 md:gap-5">
                                <div class="flex-shrink-0">
                                    <span
                                        class="inline-flex h-12 w-12 items-center justify-center rounded-xl bg-neutral-950 text-lg font-bold text-white dark:bg-neutral-800 dark:text-neutral-100 shadow-sm border border-neutral-200 dark:border-neutral-400">
                                        {{ substr($viewingProject['name'], 0, 1) }}
                                    </span>
                                </div>

                                <div class="min-w-0 flex-1">
                                    <div class="flex flex-wrap items-center gap-2 mb-1">
                                        <h2
                                            class="text-xl md:text-2xl font-bold text-neutral-900 dark:text-white tracking-tight truncate">
                                            {{ ucwords($viewingProject['name']) }}
                                        </h2>

                                    </div>

                                    @if (isset($viewingProject['client']['client_name']))
                                        <p
                                            class="flex items-center gap-1.5 text-sm text-neutral-500 dark:text-neutral-400 font-medium">
                                            {!! $statusHtml !!} | <svg class="w-4 h-4 opacity-70"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            {{ $viewingProject['client']['client_name'] }}
                                        </p>
                                        <p
                                            class="text-[10px] mt-3 font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500">
                                            LAST UPDATED:
                                            {{ \Carbon\Carbon::parse($viewingProject['updated_at'])->diffForHumans() }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="px-4 py-6 md:px-6 border-t border-neutral-100 dark:border-neutral-600">
                            <dl class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <div class="flex flex-col gap-1">
                                    <dt
                                        class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500">
                                        Project Value
                                    </dt>
                                    <dd class="text-xl font-bold text-neutral-900 dark:text-white tabular-nums">
                                        <span
                                            class="text-neutral-400 dark:text-neutral-500 font-medium mr-0.5">{{ $viewingProject['project_currency'] ?? 'USD' }}</span>
                                        {{ number_format($viewingProject['value'], 2) }}
                                    </dd>
                                </div>

                                <div class="flex flex-col gap-1">
                                    <dt
                                        class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500">
                                        Hourly Rate
                                    </dt>
                                    <dd class="text-xl font-bold text-neutral-900 dark:text-white tabular-nums">
                                        <span
                                            class="text-neutral-400 dark:text-neutral-500 font-medium mr-0.5">{{ $viewingProject['project_currency'] ?? 'USD' }}</span>
                                        {{ number_format($viewingProject['hourly_rate'], 2) }}<span
                                            class="text-sm font-normal text-neutral-400">/hr</span>
                                    </dd>
                                </div>

                                <div class="flex flex-col gap-1">
                                    <dt
                                        class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500">
                                        deadline
                                    </dt>
                                    <dd
                                        class="text-sm md:text-base font-semibold text-neutral-700 dark:text-neutral-300">
                                        {{ \Carbon\Carbon::parse($viewingProject['deadline'])->format('M d, Y') }}
                                        <p class="text-xs text-neutral-400 font-thin">
                                            <span class="uppercase">Issued:</span>
                                            {{ \Carbon\Carbon::parse($viewingProject['created_at'])->format('M d, Y') }}
                                        </p>
                                    </dd>
                                </div>

                                <div class="col-span-1 md:col-span-3">
                                    <dt
                                        class="text-[10px] font-bold uppercase tracking-widest text-neutral-400 dark:text-neutral-500 mb-2">
                                        Description
                                    </dt>
                                    <dd
                                        class="rounded-xl border border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-900/50 p-4 text-sm leading-relaxed text-neutral-600 dark:text-neutral-400">
                                        {{ $viewingProject['description'] ?: 'No description provided.' }}
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                @else
                    <div class="flex flex-col items-center justify-center py-20 text-neutral-400">
                        <svg class="w-12 h-12 mb-3 opacity-20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        <p class="text-sm font-medium">No project selected.</p>
                    </div>
                @endif
            </div>
        </div>
    </flux:modal>

    {{-- Edit Project Modal --}}
    <flux:modal name="edit-project-modal" class="min-h-[600px] w-full md:min-w-[800px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="edit">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="edit">
                @if (!empty($editingProject))
                    <div class="space-y-6">
                        <div class="border-b border-neutral-100 dark:border-white/5 pb-4">
                            <h3 class="text-lg md:text-xl font-bold text-neutral-900 dark:text-white">
                                Edit Project: <span
                                    class="text-indigo-600 dark:text-indigo-400">{{ ucwords($editingProject['name']) }}</span>
                            </h3>
                        </div>

                        <form wire:submit.prevent="update" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <x-input-field label="Project Name" model="editingProject.name" />
                                <x-input-field label="Value" type="number" step="0.01"
                                    model="editingProject.value" />

                                <div class="w-full group">
                                    <label
                                        class="block text-xs md:text-sm font-medium leading-6 text-neutral-900 dark:text-neutral-400 transition-colors duration-200">Client</label>
                                    <div class="mt-2 relative">
                                        <select wire:model="editingProject.client_id"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-neutral-900 dark:text-white bg-white dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 text-sm md:text-base leading-6 transition-shadow duration-200 ease-in-out">
                                            @foreach ($clients as $client)
                                                <option value="{{ $client->id }}">
                                                    {{ ucwords($client->client_name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <x-input-field type="number" model="editingProject.hourly_rate" placeholder="0.00"
                                        label="Rate/Hr." required />
                                </div>

                                <div class="w-full group">
                                    <label
                                        class="block text-xs md:text-sm font-medium leading-6 text-neutral-900 dark:text-neutral-400 transition-colors duration-200">Status</label>
                                    <div class="mt-2 relative">
                                        <select wire:model="editingProject.status"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-neutral-900 dark:text-white bg-white dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 text-sm md:text-base leading-6 transition-shadow duration-200 ease-in-out">
                                            <option value="active">Active</option>
                                            <option value="in-progress">In Progress</option>
                                            <option value="on-hold">On Hold</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <x-textarea-field label="Description" model="editingProject.description"
                                rows="4" />

                            <div class="flex justify-end gap-3 pt-6 border-t border-neutral-100 dark:border-white/5">
                                <flux:modal.close>
                                    <x-secondary-button>Cancel</x-secondary-button>
                                </flux:modal.close>
                                <x-primary-button wire:click="update">Save Changes</x-primary-button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="text-center text-neutral-500 py-12">No project selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>

</div>
