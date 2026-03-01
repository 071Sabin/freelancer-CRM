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
        <flux:modal.trigger name="add-project-modal">
            <x-primary-button class="flex gap-1" wire:click="resetForm">
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
    <x-projects.show-add-project-form :clients="$clients" :currencies="$currencies" :project_form="$project_form" />


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
    <flux:modal name="view-project-modal"
        class="w-full max-w-2xl !p-0 shadow-2xl rounded-2xl">

        <div wire:loading wire:target="view"
            class="absolute inset-0 z-10 flex items-center justify-center bg-white/80 dark:bg-neutral-900/80 backdrop-blur-sm rounded-2xl">
            <flux:icon.loading class="w-8 h-8 text-neutral-600 dark:text-neutral-400" />
        </div>

        <div wire:loading.remove wire:target="view" class="w-full flex flex-col max-h-[90vh]">
            @if (!empty($viewingProject))
                @php
                    // Modern "Badge" styling with Ring utilities for high-DPI crispness
                    $statusHtml = match (strtolower($viewingProject['status'] ?? '')) {
                        'active'
                            => '<span class="inline-flex items-center rounded-md bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-600/20 dark:bg-blue-500/10 dark:text-blue-400 dark:ring-blue-500/20">Active</span>',
                        'in-progress'
                            => '<span class="inline-flex items-center rounded-md bg-amber-50 px-2.5 py-1 text-xs font-medium text-amber-800 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-500 dark:ring-amber-400/20">In Progress</span>',
                        'completed'
                            => '<span class="inline-flex items-center rounded-md bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/20">Completed</span>',
                        'cancelled'
                            => '<span class="inline-flex items-center rounded-md bg-red-50 px-2.5 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/10 dark:bg-red-400/10 dark:text-red-400 dark:ring-red-400/20">Cancelled</span>',
                        default
                            => '<span class="inline-flex items-center rounded-md bg-neutral-50 px-2.5 py-1 text-xs font-medium text-neutral-600 ring-1 ring-inset ring-neutral-500/10 dark:bg-neutral-400/10 dark:text-neutral-400 dark:ring-neutral-400/20">' .
                            ucfirst($viewingProject['status'] ?? 'Unknown') .
                            '</span>',
                    };
                @endphp

                <div
                    class="flex items-start justify-between px-6 pt-6 pb-5 border-b sm:px-8 border-neutral-200 dark:border-neutral-600 shrink-0">
                    <div class="flex items-center gap-4">
                        <div
                            class="flex items-center justify-center shrink-0 w-14 h-14 text-xl font-bold bg-neutral-900 text-white rounded-xl shadow-sm dark:bg-white dark:text-neutral-900 ring-1 ring-black/5 dark:ring-white/10">
                            {{ substr($viewingProject['name'], 0, 1) }}
                        </div>
                        <div>
                            <div class="flex items-center gap-3">
                                <flux:heading size="xl" level="2"
                                    class="text-neutral-900 dark:text-white truncate max-w-[200px] sm:max-w-[350px]">
                                    {{ ucwords($viewingProject['name']) }}
                                </flux:heading>
                                <div>{!! $statusHtml !!}</div>
                            </div>
                            @if (isset($viewingProject['client']['client_name']))
                                <div
                                    class="flex items-center gap-1.5 mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                                    <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                    <span>{{ $viewingProject['client']['client_name'] }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="px-6 py-6 overflow-y-auto sm:px-8 sm:py-8 flex flex-col gap-8">

                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                        <div class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Project
                                Value</span>
                            <span class="text-lg font-semibold text-neutral-900 dark:text-white tabular-nums">
                                <span
                                    class="text-sm font-normal text-neutral-400 mr-1">{{ $viewingProject['currency']['code'] ?? 'USD' }}</span>{{ number_format($viewingProject['value'], 2) }}
                            </span>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Hourly Rate</span>
                            <span class="text-lg font-semibold text-neutral-900 dark:text-white tabular-nums">
                                <span
                                    class="text-sm font-normal text-neutral-400 mr-1">{{ $viewingProject['currency']['code'] ?? 'USD' }}</span>{{ number_format($viewingProject['hourly_rate'], 2) }}<span
                                    class="text-sm font-normal text-neutral-400 ml-0.5">/hr</span>
                            </span>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Timeline</span>
                            <div class="flex flex-col">
                                <span class="text-sm font-medium text-neutral-900 dark:text-white">
                                    Due {{ \Carbon\Carbon::parse($viewingProject['deadline'])->format('M d, Y') }}
                                </span>
                                <span class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                    Issued {{ \Carbon\Carbon::parse($viewingProject['created_at'])->format('M d, Y') }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Description</span>
                        <div
                            class="p-4 text-sm leading-relaxed rounded-xl bg-neutral-50 dark:bg-white/5 text-neutral-700 dark:text-neutral-300 ring-1 ring-inset ring-neutral-200 dark:ring-white/10">
                            {!! nl2br(e($viewingProject['description'] ?: 'No description provided.')) !!}
                        </div>
                    </div>

                    <div class="text-xs text-neutral-400 dark:text-neutral-500 w-full text-right">
                        Last updated {{ \Carbon\Carbon::parse($viewingProject['updated_at'])->diffForHumans() }}
                    </div>

                </div>

                <div
                    class="flex items-center justify-end px-6 py-4 bg-neutral-50 sm:px-8 border-t border-neutral-200 rounded-b-2xl dark:bg-neutral-900/50 dark:border-neutral-800 shrink-0">
                    <flux:modal.close>
                        <x-secondary-button>Close</x-secondary-button>

                    </flux:modal.close>
                </div>
            @else
                <div class="flex flex-col items-center justify-center p-16 text-center">
                    <div
                        class="flex items-center justify-center w-12 h-12 mb-4 rounded-full bg-neutral-100 dark:bg-neutral-800">
                        <svg class="w-6 h-6 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <h3 class="text-sm font-medium text-neutral-900 dark:text-white">No Project Selected</h3>
                    <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Select a project from the list to
                        view its details.</p>
                    <button type="button" x-on:click="$modal.close('view-project-modal')"
                        class="mt-6 text-sm font-medium text-neutral-900 transition-colors hover:text-neutral-600 dark:text-white dark:hover:text-neutral-300">
                        Go back
                    </button>
                </div>
            @endif
        </div>
    </flux:modal>

    {{-- Edit Project Modal --}}
    <flux:modal name="edit-project-modal"
        class="w-full max-w-2xl">

        <div wire:loading wire:target="edit"
            class="absolute inset-0 z-20 flex items-center justify-center bg-white/70 dark:bg-neutral-800/70 backdrop-blur-sm rounded-2xl">
            <div
                class="flex flex-col items-center gap-3 p-4 border shadow-lg rounded-xl border-neutral-100 dark:bg-neutral-900 dark:border-neutral-800">
                <flux:icon.loading class="w-6 h-6 animate-spin text-neutral-900 dark:text-white" />
                <span class="text-xs font-semibold tracking-wide text-neutral-600 dark:text-neutral-300">Loading
                    project...</span>
            </div>
        </div>

        <div wire:loading.remove wire:target="edit" class="flex flex-col">
            @if ($project_form->project)
                <form wire:submit.prevent="update" class="flex flex-col">

                    <div class="flex items-start gap-4 pb-5 border-b border-neutral-200 dark:border-neutral-600/80">
                        <div
                            class="flex items-center justify-center shrink-0 w-12 h-12 text-lg font-semibold bg-white border rounded-xl shadow-sm text-neutral-600 border-neutral-200 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300">
                            {{ substr($project_form->name ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <div
                                class="flex items-center gap-2 mb-1 text-sm font-medium text-neutral-500 dark:text-neutral-400">
                                <span>Projects</span>
                                <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                                </svg>
                                <span class="text-blue-600 dark:text-blue-400">Edit Project</span>
                            </div>
                            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">
                                {{ $project_form->name }}
                            </flux:heading>
                        </div>
                    </div>

                    <div class="space-y-6 mt-3">

                        <div class="grid grid-cols-1 gap-5 sm:grid-cols-3">
                            <div class="sm:col-span-3">
                                <x-input-field label="Project Name" type="text" model="project_form.name" required />
                            </div>

                            {{-- CLIENT LIST --}}
                            <div>
                                <flux:select wire:model.live="project_form.client_id" label="Client"
                                    placeholder="Search..." searchable>
                                    @foreach ($clients as $client)
                                        <flux:select.option value="{{ $client->id }}">
                                            {{ ucwords($client->client_name) }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>
                            </div>

                            {{-- STATUS --}}
                            <div>
                                <flux:select wire:model="project_form.status" label="Status">
                                    <flux:select.option value="active">Active</flux:select.option>
                                    <flux:select.option value="in_progress">In Progress</flux:select.option>
                                    <flux:select.option value="on_hold">On Hold</flux:select.option>
                                    <flux:select.option value="completed">Completed</flux:select.option>
                                    <flux:select.option value="cancelled">Cancelled</flux:select.option>
                                </flux:select>
                            </div>

                            <x-input-field label="Deadline" type="date" model="project_form.deadline" required />

                        </div>

                        <fieldset
                            class="p-5 border rounded-xl bg-neutral-50/50 dark:bg-neutral-900/20 border-neutral-200/80 dark:border-neutral-600">
                            <legend
                                class="px-2 text-xs font-semibold tracking-widest uppercase text-neutral-500 dark:text-neutral-400">
                                Billing
                            </legend>
                            <div class="grid grid-cols-1 gap-5 mt-1 sm:grid-cols-3">

                                <flux:select wire:model="project_form.currency_id" label="Currency" searchable>
                                    @foreach ($currencies as $c)
                                        <flux:select.option value="{{ (string) $c->id }}">
                                            {{ $c->code }} ({{ $c->symbol }})
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>

                                <x-input-field label="Project Value" type="number" step="0.01" model="project_form.value" placeholder="0.00" required/>

                                <x-input-field type="number" model="project_form.hourly_rate" placeholder="0.00"
                                    label="Hourly Rate" step="0.01" required />
                            </div>
                        </fieldset>

                        <div>
                            <flux:textarea label="Project Description" wire:model.defer="project_form.description"
                                placeholder="Add context, goals, or important notes about this project..."
                                rows="3" />
                        </div>
                    </div>

                    <div class="flex items-center justify-between py-4">

                        {{-- LEFT SIDE --}}
                        <div class="flex items-center min-h-[28px]">

                            <div wire:dirty.class="flex" wire:dirty.remove.class="hidden" wire:target="project_form"
                                class="hidden items-center gap-2 text-xs sm:text-sm font-medium text-amber-600 dark:text-amber-400">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-4 h-4 shrink-0">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>

                                <span class="leading-none">Unsaved changes</span>
                            </div>

                        </div>

                        {{-- RIGHT SIDE --}}
                        <div class="flex items-center gap-3">
                            <flux:modal.close>
                                <x-secondary-button>Cancel</x-secondary-button>
                            </flux:modal.close>

                            <x-primary-button wire:click="update" wire:loading.attr="disabled">
                                <span wire:loading.remove wire:target="update">Save Project</span>
                                <span wire:loading wire:target="update" class="flex items-center gap-2">
                                    <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-20" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-100" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    Saving...
                                </span>
                            </x-primary-button>
                        </div>

                    </div>
                </form>
            @else
                <div class="flex flex-col items-center justify-center px-6 py-20 text-center">
                    <div
                        class="relative flex items-center justify-center w-16 h-16 mb-5 bg-white border rounded-2xl dark:bg-neutral-800 shadow-sm border-neutral-100 dark:border-neutral-700 ring-4 ring-neutral-50 dark:ring-neutral-800/50">
                        <svg class="w-7 h-7 text-neutral-400 dark:text-neutral-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-neutral-900 dark:text-white">No workspace selected</h3>
                    <p class="max-w-xs mt-2 text-sm text-neutral-500 dark:text-neutral-400">
                        Please select a project to view and edit its configuration.
                    </p>
                </div>
            @endif
        </div>

    </flux:modal>

</div>
