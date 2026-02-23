@props(['clients'])

<flux:modal name="add-project">
    <form wire:submit.prevent="createProject" class="bg-white dark:bg-neutral-800 rounded-lg w-full max-w-3xl">

        <div class="flex items-start justify-between">
            <h1 class="text-xl font-bold">Add Project</h1>
        </div>

        <x-hr-divider />

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-x-8 gap-y-6">

            <div class="space-y-1.5">
                <x-input-field model="name" type="text" placeholder="Enter project name" label="Project Name"
                    required />
                @error('name')
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5">
                <x-input-field model="value" type="number" step="0.01" placeholder="1500.00" label="Project Value"
                    required />
                @error('value')
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="space-y-1.5 lg:col-span-1">
                <label class="block text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                    Client <span class="text-red-500">*</span>
                </label>

                <select wire:model.live="client_id"
                    class="block w-full rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-4 py-2.5 text-sm text-neutral-900 dark:text-neutral-100 shadow-sm transition-all duration-200 ease-in-out focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900 dark:focus:border-neutral-100 dark:focus:ring-neutral-100">
                    <option value="" class="text-neutral-500">-- Select client --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror

                <div
                    class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-4 rounded-lg border border-neutral-200 dark:border-neutral-800 bg-neutral-50 dark:bg-neutral-800/40 p-4">
                    <x-input-field type="text" model="project_currency" placeholder="e.g. USD" label="Currency"
                        required />
                    <x-input-field type="text" model="hourly_rate" placeholder="e.g. 150.00"
                        label="Rate/Hr." required />
                </div>
            </div>

            <div class="space-y-1.5">
                <x-select id="status" label="Status" model="status" :options="[
                    'active' => 'Active',
                    'in_progress' => 'In Progress',
                    'on_hold' => 'On Hold',
                    'completed' => 'Completed',
                    'cancelled' => 'Cancelled',
                ]" placeholder="Select status"
                    required />
                @error('status')
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <x-input-field type="date" model="deadline" label="Deadline" required />
            </div>

            <div class="space-y-1.5 lg:col-span-2">
                <label class="block text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                    Project Description
                </label>
                <textarea wire:model.defer="description" placeholder="Enter comprehensive project details..."
                    class="block w-full min-h-[120px] resize-y rounded-lg border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 px-4 py-3 text-sm text-neutral-900 dark:text-neutral-100 shadow-sm transition-all duration-200 ease-in-out placeholder:text-neutral-400 focus:border-neutral-900 focus:outline-none focus:ring-1 focus:ring-neutral-900 dark:focus:border-neutral-100 dark:focus:ring-neutral-100"></textarea>
                @error('description')
                    <p class="text-sm font-medium text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>



        <div class="mt-5 flex items-center justify-between">
            <div class="space-x-2">
                <x-primary-button type="submit">Create</x-primary-button>
            </div>
        </div>

    </form>

</flux:modal>
