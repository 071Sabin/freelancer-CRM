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
    <flux:modal name="view-project-modal"
        class="w-full max-w-2xl !p-0 bg-white shadow-2xl rounded-2xl dark:bg-neutral-900">

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
                                    class="text-sm font-normal text-neutral-400 mr-1">{{ $viewingProject['project_currency'] ?? 'USD' }}</span>{{ number_format($viewingProject['value'], 2) }}
                            </span>
                        </div>

                        <div class="flex flex-col gap-1.5">
                            <span class="text-xs font-medium text-neutral-500 dark:text-neutral-400">Hourly Rate</span>
                            <span class="text-lg font-semibold text-neutral-900 dark:text-white tabular-nums">
                                <span
                                    class="text-sm font-normal text-neutral-400 mr-1">{{ $viewingProject['project_currency'] ?? 'USD' }}</span>{{ number_format($viewingProject['hourly_rate'], 2) }}<span
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
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <x-input-field label="Project Name" model="editingProject.name" />
                                <x-input-field label="Value" type="number" step="0.01"
                                    model="editingProject.value" />
                                <x-input-field label="Deadline" type="date" model="editingProject.deadline"
                                    required />
                            </div>
                            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="w-full group">
                                    <label
                                        class="block text-xs md:text-sm font-medium leading-6 text-neutral-900 dark:text-neutral-400 transition-colors duration-200">Client</label>
                                    <div class="relative">
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
                                    <x-input-field type="number" model="editingProject.hourly_rate"
                                        placeholder="0.00" label="Rate/Hr." required />
                                </div>
                                <div>
                                    <x-input-field type="text" model="editingProject.project_currency"
                                        placeholder="eg. USD" label="Curr." required />
                                </div>

                                <div class="w-full group">
                                    <label
                                        class="block text-xs md:text-sm font-medium leading-6 text-neutral-900 dark:text-neutral-400 transition-colors duration-200">Status</label>
                                    <div class="relative">
                                        <select wire:model="editingProject.status"
                                            class="block w-full rounded-lg border-0 py-2.5 px-3 text-neutral-900 dark:text-white bg-white dark:bg-neutral-900 shadow-sm ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 text-sm md:text-base leading-6 transition-shadow duration-200 ease-in-out">
                                            <option value="active">Active</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="on_hold">On Hold</option>
                                            <option value="completed">Completed</option>
                                            <option value="cancelled">Cancelled</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <x-textarea-field label="Description" model="editingProject.description" rows="4"
                                placeholder="Project notes for personal use...." />

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
