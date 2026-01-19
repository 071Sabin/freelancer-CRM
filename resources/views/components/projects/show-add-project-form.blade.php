@props(['clients'])

<div id="addProjectModal" class="fixed inset-0 z-90 bg-black/50 backdrop-blur-md overflow-y-auto px-4 py-6">
    <div class="min-h-full flex items-start justify-center">
        <form wire:submit.prevent="createProject" class="bg-white dark:bg-neutral-800 rounded-lg w-full max-w-3xl p-5">

            <div class="flex items-start justify-between">
                <h1 class="text-xl font-bold">Add Project</h1>

                <button type="button" wire:click="showAddProjectsForm"
                    class="text-neutral-400 hover:text-red-500 cursor-pointer">
                    <i class="bi bi-x-lg"></i>
                </button>
            </div>

            <x-hr-divider/>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                <div>
                    <x-input-field model="name" type="text" placeholder="Enter project name" label="Project Name"
                        required />
                    @error('name')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <x-input-field model="value" type="number" step="0.01" placeholder="1500.00"
                        label="Project Value" required />
                    @error('value')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div class="lg:col-span-2">
                    <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Project
                        Description</label>
                    <textarea wire:model.defer="description" placeholder="Project details..."
                        class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500"></textarea>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Client <span
                            class="text-red-500">*</span></label>
                    <select wire:model.defer="client_id"
                        class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="">-- Select client --</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Status <span
                            class="text-red-500">*</span></label>
                    <select wire:model="status"
                        class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500">
                        <option value="pending">Pending</option>
                        <option value="in-progress">In Progress</option>
                        <option value="completed">Completed</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="mt-5 flex items-center justify-between">
                <div class="space-x-2">
                    <x-primary-button type="submit">Create</x-primary-button>
                    <x-secondary-button wire:click="showAddProjectsForm">Cancel</x-secondary-button>
                </div>
            </div>

        </form>
    </div>
</div>
