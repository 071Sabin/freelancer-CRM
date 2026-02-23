@props(['clients'])

<flux:modal name="add-project">
    <form wire:submit.prevent="createProject" class="flex flex-col w-full max-w-3xl rounded-xl">

        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800">
            <div>
                <h2 class="text-lg font-semibold tracking-tight sm:text-xl text-neutral-900 dark:text-neutral-100">Add Project</h2>
                <p class="mt-0.5 text-xs sm:text-sm text-neutral-500 dark:text-neutral-400">Enter the project details and billing information.</p>
            </div>
        </div>

        <div class="flex flex-col gap-y-5 pt-5 sm:gap-y-6">

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="space-y-1">
                    <x-input-field model="name" type="text" placeholder="e.g. Acme Redesign" label="Project Name" required />
                    @error('name') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                        Client <span class="text-red-500">*</span>
                    </label>
                    <select wire:model.live="client_id"
                        class="block w-full px-3 py-2 text-sm transition-colors bg-white border rounded-lg shadow-sm border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900 dark:focus:border-neutral-100">
                        <option value="" class="text-neutral-500">-- Select client --</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                        @endforeach
                    </select>
                    @error('client_id') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">
                <div class="space-y-1">
                    <x-select id="status" label="Status" model="status" :options="[
                        'active' => 'Active',
                        'in_progress' => 'In Progress',
                        'on_hold' => 'On Hold',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]" placeholder="Select status" required />
                    @error('status') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>

                <div class="space-y-1">
                    <x-input-field type="date" model="deadline" label="Deadline" required />
                    @error('deadline') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="p-4 border rounded-lg border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-800/20">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                    <div class="space-y-1">
                        <x-input-field model="value" type="number" step="0.01" placeholder="1500.00" label="Project Value" required />
                        @error('value') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-field type="text" model="project_currency" placeholder="USD" label="Currency" required />
                        @error('project_currency') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                    <div class="space-y-1">
                        <x-input-field type="text" model="hourly_rate" placeholder="150.00" label="Rate/Hr." required />
                        @error('hourly_rate') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="space-y-1">
                <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">Description</label>
                <textarea wire:model.defer="description" placeholder="Brief project details..."
                    class="block w-full min-h-[80px] sm:min-h-[100px] resize-y px-3 py-2 text-sm transition-colors bg-white border rounded-lg shadow-sm border-neutral-300 dark:border-neutral-700 dark:bg-neutral-900 text-neutral-900 dark:text-neutral-100 placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900 dark:focus:border-neutral-100"></textarea>
                @error('description') <p class="text-[11px] sm:text-xs font-medium text-red-500 dark:text-red-400">{{ $message }}</p> @enderror
            </div>

        </div>

        <div class="flex items-center justify-end py-4 rounded-b-xl">
            <x-primary-button type="submit" class="w-fit">Create Project</x-primary-button>
        </div>

    </form>
</flux:modal>
