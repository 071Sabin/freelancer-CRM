@props(['clients', 'currencies','project_form'])

<flux:modal name="add-project-modal"
    class="w-full max-w-2xl">

    <div wire:loading wire:target="createProject"
        class="absolute inset-0 z-20 flex items-center justify-center bg-white/70 dark:bg-[#141414]/70 backdrop-blur-sm rounded-2xl">
        <div class="flex flex-col items-center gap-3 p-4 bg-white border shadow-lg rounded-xl border-neutral-100 dark:bg-neutral-900 dark:border-neutral-800">
            <flux:icon.loading class="w-6 h-6 animate-spin text-neutral-900 dark:text-white" />
            <span class="text-xs font-semibold tracking-wide text-neutral-600 dark:text-neutral-300">Creating project...</span>
        </div>
    </div>

    <div wire:loading.remove wire:target="createProject" class="flex flex-col">
        @if (!$project_form->project)
            <form wire:submit.prevent="createProject" class="flex flex-col">

                <div class="flex items-start gap-4 pb-5 border-b border-neutral-200 dark:border-neutral-600/80">
                    <div class="flex items-center justify-center shrink-0 w-12 h-12 text-lg font-semibold bg-white border rounded-xl shadow-sm text-neutral-600 border-neutral-200 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1 text-sm font-medium text-neutral-500 dark:text-neutral-400">
                            <span>Projects</span>
                            <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="text-blue-500">New Project</span>
                        </div>
                        <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">
                            Add Project
                        </flux:heading>
                    </div>
                </div>

                <div class="space-y-6 mt-3">

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                        
                        <div class="md:col-span-3">
                            <x-input-field label="Project Name" model="project_form.name" placeholder="Enter project name" required type="text"/>
                        </div>

                        <div>
                            <flux:select wire:model.live="project_form.client_id" label="Client" placeholder="Search..." searchable>
                                @foreach ($clients as $client)
                                    <flux:select.option value="{{ $client->id }}">
                                        {{ ucwords($client->client_name) }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>

                        <div>
                            <flux:select wire:model="project_form.status" label="Status">
                                <flux:select.option value="active">Active</flux:select.option>
                                <flux:select.option value="in_progress">In Progress</flux:select.option>
                                <flux:select.option value="on_hold">On Hold</flux:select.option>
                                <flux:select.option value="completed">Completed</flux:select.option>
                                <flux:select.option value="cancelled">Cancelled</flux:select.option>
                            </flux:select>
                        </div>

                        <div>
                            <x-input-field label="Deadline" type="date" model="project_form.deadline" required />
                        </div>
                    </div>

                    <fieldset class="p-5 border rounded-xl bg-neutral-50/50 dark:bg-neutral-900/20 border-neutral-200/80 dark:border-neutral-600">
                        <legend class="px-2 text-xs font-semibold tracking-widest uppercase text-neutral-500 dark:text-neutral-400">
                            Billing
                        </legend>
                        <div class="grid grid-cols-1 gap-5 mt-1 md:grid-cols-3">
                            
                            <flux:select wire:model="project_form.currency_id" label="Currency" searchable>
                                @foreach ($currencies as $c)
                                    <flux:select.option value="{{ (string) $c->id }}">
                                        {{ $c->code }} - {{ $c->symbol }}
                                    </flux:select.option>
                                @endforeach
                            </flux:select>

                            <x-input-field label="Project Value" type="number" step="0.01" model="project_form.value" required placeholder="0.00" />

                            <x-input-field type="number" model="project_form.hourly_rate" placeholder="0.00" label="Rate/Hr." step="0.01" required />
                        </div>
                    </fieldset>

                    <div>
                        <flux:textarea label="Project Description" wire:model.defer="project_form.description"
                            placeholder="Brief project details, goals, or notes..." rows="3" />
                    </div>
                </div>

                <div class="flex items-center justify-end py-4 mt-2">
                    <div class="flex items-center gap-3">
                        <flux:modal.close>
                            <x-secondary-button>Cancel</x-secondary-button>
                        </flux:modal.close>

                        <x-primary-button type="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="createProject">Create Project</span>
                            <span wire:loading wire:target="createProject" class="flex items-center gap-2">
                                <svg class="w-4 h-4 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-20" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-100" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Creating...
                            </span>
                        </x-primary-button>
                    </div>
                </div>
            </form>
        @else
            <div class="flex flex-col items-center justify-center px-6 py-20 text-center">
                <div class="relative flex items-center justify-center w-16 h-16 mb-5 bg-white border rounded-2xl dark:bg-neutral-800 shadow-sm border-neutral-100 dark:border-neutral-700 ring-4 ring-neutral-50 dark:ring-neutral-800/50">
                    <svg class="w-7 h-7 text-neutral-400 dark:text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-neutral-900 dark:text-white">No project configuration available</h3>
            </div>
        @endif
    </div>

</flux:modal>

