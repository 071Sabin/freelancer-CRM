<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8 space-y-6">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <a href="{{ route('projects') }}" wire:navigate
                class="inline-flex items-center text-sm font-medium text-zinc-500 hover:text-zinc-800 dark:hover:text-zinc-200 transition-colors mb-2">
                <flux:icon.chevron-left class="size-4 mr-1" />
                Back to Projects
            </a>

            <div class="flex items-center gap-3">
                <flux:heading size="xl" class="font-bold">{{ $project->name }}</flux:heading>
                <flux:badge color="blue" size="sm" class="uppercase">{{ $project->status ?? 'Active' }}
                </flux:badge>
            </div>
            <flux:subheading class="mt-1">
                Client: <span
                    class="font-semibold text-zinc-800 dark:text-zinc-200">{{ $project->client->client_name }}</span>
            </flux:subheading>
        </div>

        <div class="flex items-center gap-3">
            <flux:button variant="ghost" icon="pencil"
                wire:click="$dispatch('edit-project', { id: {{ $project->id }} })">
                Edit Details
            </flux:button>
            <x-primary-button wire:click='sendWhatsappMessage({{ $project->id }})'>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-4">
                    <path
                        d="M3.478 2.404a.75.75 0 0 0-.926.941l2.432 7.905H13.5a.75.75 0 0 1 0 1.5H4.984l-2.432 7.905a.75.75 0 0 0 .926.94 60.519 60.519 0 0 0 18.445-8.986.75.75 0 0 0 0-1.218A60.517 60.517 0 0 0 3.478 2.404Z" />
                </svg>
                <span wire:loading.remove wire:target="sendWhatsappMessage">
                    Send Update
                </span>

                <span wire:loading wire:target="sendWhatsappMessage">
                    Sending...
                </span>
            </x-primary-button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-start">

        <div class="lg:col-span-2 space-y-6">

            <div
                class="p-4 flex flex-wrap gap-6 sm:gap-12 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-200 dark:border-zinc-700/50 shadow-sm">
                <div>
                    <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Deadline</p>
                    <p class="mt-1 font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ \Carbon\Carbon::parse($project->deadline)->format('M d, Y') }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Project Value</p>
                    <p class="mt-1 font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ $project->currency->symbol ?? '$' }} {{ number_format($project->value, 2) }}</p>
                </div>
                <div>
                    <p class="text-xs text-zinc-500 uppercase tracking-wide font-medium">Hourly Rate</p>
                    <p class="mt-1 font-semibold text-zinc-900 dark:text-zinc-100">
                        {{ $project->currency->symbol ?? '$' }}{{ number_format($project->hourly_rate, 2) }}</p>
                </div>
            </div>

            <livewire:projects.task-manager :project="$project" />

        </div>

        <div class="space-y-6">

            <div class="p-5 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <div class="flex justify-between items-center mb-4">
                    <flux:heading size="md">Invoices</flux:heading>
                    <flux:button size="sm" variant="ghost" icon="plus">Create</flux:button>
                </div>

                <div
                    class="border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-lg p-6 text-center text-zinc-500 text-sm">
                    No invoices generated yet.
                </div>
            </div>

            <div class="p-5 bg-white dark:bg-zinc-900 rounded-xl border border-zinc-200 dark:border-zinc-800 shadow-sm">
                <flux:heading size="md" class="mb-3">Project Scope</flux:heading>
                <div
                    class="text-sm text-zinc-600 dark:text-zinc-400 whitespace-pre-line bg-zinc-50 dark:bg-zinc-800/50 p-3 rounded-lg border border-zinc-200 dark:border-zinc-700/50">
                    {{ $project->description ?: 'No specific description provided.' }}
                </div>
            </div>

        </div>
    </div>

    {{-- Edit Project Modal --}}
    <flux:modal name="edit-project-modal" class="w-full max-w-2xl">

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

                                <x-input-field label="Project Value" type="number" step="0.01"
                                    model="project_form.value" placeholder="0.00" required />

                                <x-input-field type="number" model="project_form.hourly_rate" placeholder="0.00"
                                    label="Hourly Rate" step="0.01" required />
                            </div>
                        </fieldset>

                        <div>
                            <flux:textarea label="Project Description" wire:model.defer="project_form.description"
                                placeholder="Add context, goals, or important notes about this project..."
                                rows="3" />
                        </div>
                        <div
                            class="mt-4 p-4 bg-zinc-50 dark:bg-zinc-800/50 rounded-lg border border-zinc-200 dark:border-zinc-700">
                            <flux:checkbox wire:model="notify_client"
                                label="Send update notification to client via WhatsApp"
                                description="If unchecked, the project will be saved silently." />
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
