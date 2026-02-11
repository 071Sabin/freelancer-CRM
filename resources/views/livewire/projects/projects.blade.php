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

    {{-- View Project Modal --}}
    <flux:modal name="view-project-modal"
        class="min-h-[600px] min-w-[600px] md:min-w-[800px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="view">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="view">
                @if ($viewingProject)
                    <div class="space-y-6">
                        <div class="flex justify-between items-start">
                            <flux:heading size="xl">{{ ucwords($viewingProject->name) }}</flux:heading>
                            <flux:badge size="lg"
                                :color="match($viewingProject->status) {'active' => 'blue', 'in-progress' => 'amber','completed' => 'green','cancelled' => 'red',default => 'zinc'}">
                                {{ ucwords(str_replace('-', ' ', $viewingProject->status)) }}</flux:badge>
                        </div>

                        <div class="grid grid-cols-2 gap-8">
                            <div>
                                <flux:label>Client</flux:label>
                                <div class="font-medium">{{ ucwords($viewingProject->client->client_name) }}</div>
                            </div>
                            <div>
                                <flux:label>Value</flux:label>
                                <div class="font-medium text-lg">{{ $viewingProject->client->currency ?? '$' }}
                                    {{ number_format($viewingProject->value, 2) }}</div>
                            </div>
                            <div class="col-span-2">
                                <flux:label>Description</flux:label>
                                <p class="text-neutral-600 dark:text-neutral-400">
                                    {{ ucfirst($viewingProject->description) ?? 'No description.' }}</p>
                            </div>
                        </div>

                        <div class="flex justify-end pt-6">
                            <flux:button wire:click="$dispatch('close-modal', 'view-project-modal')">Close</flux:button>
                        </div>
                    </div>
                @else
                    <div class="text-center text-neutral-500">No project selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>

    {{-- Edit Project Modal --}}
    <flux:modal name="edit-project-modal" class="min-h-[600px] md:min-w-[800px] !bg-white dark:!bg-neutral-800">
        <div>
            <div wire:loading wire:target="edit">
                <div class="flex justify-center p-8">
                    <flux:icon.loading />
                </div>
            </div>

            <div wire:loading.remove wire:target="edit">
                @if ($editingProject)
                    <div class="space-y-6">
                        <flux:heading size="lg">Edit Project: {{ ucwords($editingProject->name) }}</flux:heading>

                        <form wire:submit.prevent="update" class="space-y-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <flux:input label="Project Name" wire:model="editingProject.name" />
                                <flux:input label="Value" type="number" step="0.01"
                                    wire:model="editingProject.value" />

                                <flux:select label="Client" wire:model="editingProject.client_id">
                                    @foreach ($clients as $client)
                                        <option value="{{ $client->id }}">{{ ucwords($client->client_name) }}
                                        </option>
                                    @endforeach
                                </flux:select>

                                <flux:select label="Status" wire:model="editingProject.status">
                                    <option value="active">Active</option>
                                    <option value="in-progress">In Progress</option>
                                    <option value="on-hold">On Hold</option>
                                    <option value="completed">Completed</option>
                                    <option value="cancelled">Cancelled</option>
                                </flux:select>
                            </div>

                            <flux:textarea label="Description" wire:model="editingProject.description" />

                            <div class="flex justify-end gap-3 pt-6">
                                <flux:button variant="ghost"
                                    wire:click="$dispatch('close-modal', 'edit-project-modal')">Cancel</flux:button>
                                <flux:button type="submit" variant="primary">Save Changes</flux:button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="text-center text-neutral-500">No project selected.</div>
                @endif
            </div>
        </div>
    </flux:modal>

</div>
