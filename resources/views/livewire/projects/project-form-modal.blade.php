<div>

    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <flux:modal name="addEdit-project-modal" class="w-full max-w-2xl">

        <div wire:loading wire:target="createProject"
            class="absolute inset-0 z-20 flex items-center justify-center bg-white/70 dark:bg-[#141414]/70 backdrop-blur-sm rounded-2xl">
            <div
                class="flex flex-col items-center gap-3 p-4 bg-white border shadow-lg rounded-xl border-neutral-100 dark:bg-neutral-900 dark:border-neutral-800">
                <flux:icon.loading class="w-6 h-6 animate-spin text-neutral-900 dark:text-white" />
                <span class="text-xs font-semibold tracking-wide text-neutral-600 dark:text-neutral-300">Creating
                    project...</span>
            </div>
        </div>

        <div class="flex flex-col">

            <form wire:submit.prevent={{ $project_form->project ? 'update' : 'createProject' }} class="flex flex-col">

                <div class="flex items-start gap-4 pb-5 border-b border-neutral-200 dark:border-neutral-600/80">
                    @if ($project_form->project)
                        {{-- EDIT MODE HEADER --}}
                        <div
                            class="flex items-center justify-center shrink-0 w-12 h-12 text-lg font-semibold bg-white border rounded-xl shadow-sm text-neutral-600 border-neutral-200 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300">
                            {{ substr($project_form->name ?? 'P', 0, 1) }}
                        </div>
                        <div>
                            <div
                                class="flex items-center gap-2 mb-1 text-sm font-medium text-neutral-500 dark:text-neutral-400">
                                <span>Projects</span>
                                <flux:icon.chevron-right class="size-4 text-neutral-400" />
                                <span class="text-blue-600 dark:text-blue-400">Edit Project</span>
                            </div>
                            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">
                                {{ $project_form->name }}
                            </flux:heading>
                        </div>
                    @else
                        {{-- CREATE MODE HEADER --}}
                        <div
                            class="flex items-center justify-center shrink-0 w-12 h-12 text-lg font-semibold bg-white border rounded-xl shadow-sm text-neutral-600 border-neutral-200 dark:bg-neutral-800 dark:border-neutral-700 dark:text-neutral-300">
                            <flux:icon.folder-plus class="size-6" />
                        </div>
                        <div>
                            <div
                                class="flex items-center gap-2 mb-1 text-sm font-medium text-neutral-500 dark:text-neutral-400">
                                <span>Projects</span>
                                <flux:icon.chevron-right class="size-4 text-neutral-400" />
                                <span class="text-blue-500">New Project</span>
                            </div>
                            <flux:heading size="xl" level="1" class="text-neutral-900 dark:text-white">
                                Add Project
                            </flux:heading>
                        </div>
                    @endif
                </div>

                <div class="space-y-6 mt-5">
                    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">
                        <div class="md:col-span-3">
                            <x-input-field label="Project Name" model="project_form.name"
                                placeholder="Enter project name" required type="text" />
                        </div>

                        <div x-data="{ open: false }" class="relative" @click.outside="open = false">
                            @php
                                $clientSearch = trim($search);
                                $clientOptions = strlen($clientSearch) >= 3 ? $this->clients : collect();
                            @endphp

                            <label class="block mb-4 text-sm font-medium text-zinc-800 dark:text-white">
                                Client <span class="text-red-500">*</span>
                            </label>

                            <button type="button" x-on:click="open = ! open"
                                class="flex items-center justify-between w-full rounded-lg border border-zinc-200 bg-white px-3 py-2 text-left text-sm text-zinc-900 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500/20 dark:border-zinc-600 dark:bg-neutral-700 dark:text-white">
                                <span class="truncate">
                                    {{ $selectedClientName ? ucwords($selectedClientName) : 'Select client...' }}
                                </span>
                                <flux:icon.chevron-down class="size-4 shrink-0 text-zinc-400" />
                            </button>

                            <div x-show="open" x-transition.opacity.duration.150ms
                                class="absolute z-50 mt-1 flex w-full flex-col overflow-hidden rounded-lg border border-zinc-200 bg-white shadow-lg dark:border-zinc-600 dark:bg-zinc-800"
                                style="display: none;">
                                <div
                                    class="flex items-center border-b border-zinc-200 bg-zinc-50 px-3 dark:border-zinc-700 dark:bg-neutral-700">
                                    <flux:icon.magnifying-glass class="size-4 shrink-0 text-zinc-400" />
                                    <input type="text" wire:model.live.debounce.500ms="search"
                                        placeholder="Search clients..."
                                        x-on:keydown.escape.window="open = false"
                                        class="w-full border-0 bg-transparent px-2 py-2.5 text-sm text-zinc-900 outline-none placeholder:text-zinc-400 focus:ring-0 dark:text-white dark:placeholder:text-zinc-500" />
                                </div>

                                <ul class="max-h-56 overflow-y-auto py-1">
                                    @if (strlen($clientSearch) < 3)
                                        <li class="px-3 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                            Type at least 3 characters to search.
                                        </li>
                                    @else
                                        @forelse ($clientOptions as $client)
                                            <li wire:click="selectClient({{ $client->id }})" x-on:click="open = false"
                                                class="flex cursor-pointer items-center justify-between px-3 py-2 text-sm text-zinc-700 transition hover:bg-zinc-100 dark:text-zinc-200 dark:hover:bg-zinc-700">
                                                <span class="truncate">{{ ucwords($client->client_name) }}</span>
                                                @if ($project_form->client_id == $client->id)
                                                    <flux:icon.check class="size-4 shrink-0 text-blue-500" />
                                                @endif
                                            </li>
                                        @empty
                                            <li class="px-3 py-3 text-center text-sm text-zinc-500 dark:text-zinc-400">
                                                No clients found.
                                            </li>
                                        @endforelse
                                    @endif
                                </ul>
                            </div>

                            @error('project_form.client_id')
                                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                            @enderror
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

                    <fieldset
                        class="p-5 border rounded-xl bg-neutral-50/50 dark:bg-neutral-900/20 border-neutral-200/80 dark:border-neutral-600">
                        <legend
                            class="px-2 text-xs font-semibold tracking-widest uppercase text-neutral-500 dark:text-neutral-400">
                            Billing</legend>
                        <div class="grid grid-cols-1 gap-5 mt-1 md:grid-cols-3">
                            <flux:select wire:model="project_form.currency_id" label="Currency"
                                placeholder="-- Currency --">
                                @foreach ($currencies as $c)
                                    <flux:select.option value="{{ (string) $c->id }}">{{ $c->code }} -
                                        {{ $c->symbol }}</flux:select.option>
                                @endforeach
                            </flux:select>
                            <x-input-field label="Project Value" type="number" step="0.01"
                                model="project_form.value" required placeholder="0.00" />
                            <x-input-field type="number" model="project_form.hourly_rate" placeholder="0.00"
                                label="Rate/Hr." step="0.01" required />
                        </div>
                    </fieldset>

                    <div>
                        <flux:textarea label="Project Description" wire:model.defer="project_form.description"
                            placeholder="Brief project details, goals, or notes..." rows="3" />
                    </div>

                    <div
                        class="mt-4 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                        <flux:checkbox wire:model="notify_client"
                            label="Send update notification to client via WhatsApp"
                            description="If unchecked, the project will be saved silently." class="cursor-pointer" />
                    </div>
                </div>

                <div class="flex items-center justify-between py-4 mt-2">
                    {{-- LEFT SIDE: Unsaved changes indicator (Only show in edit mode if needed, or keep generic) --}}
                    <div class="flex items-center min-h-[28px]">
                        <div wire:dirty.class="flex" wire:dirty.remove.class="hidden" wire:target="project_form"
                            class="hidden items-center gap-2 text-xs sm:text-sm font-medium text-amber-600 dark:text-amber-400">
                            <flux:icon.exclamation-triangle class="size-4 shrink-0" />
                            <span class="leading-none">Unsaved changes</span>
                        </div>
                    </div>

                    {{-- RIGHT SIDE: Action Buttons --}}
                    <div class="flex items-center gap-3">
                        <flux:modal.close>
                            <x-secondary-button>Cancel</x-secondary-button>
                        </flux:modal.close>

                        <x-primary-button type="submit" wire:loading.attr="disabled">
                            <span wire:loading.remove wire:target="createProject, update">
                                {{ $project_form->project ? 'Save Project' : 'Create Project' }}
                            </span>

                            <span wire:loading wire:target="createProject, update" class="flex items-center gap-2">
                                <flux:icon.arrow-path class="size-4 animate-spin" />
                                {{ $project_form->project ? 'Saving...' : 'Creating...' }}
                            </span>
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>

    </flux:modal>

</div>
