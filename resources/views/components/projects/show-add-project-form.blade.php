@props(['clients'])

<div id="addProjectModal"
    class="modal border border-white fixed top-0 left-0 bg-black/50 backdrop-blur-md w-full h-full flex items-center justify-center">
    <form wire:submit.prevent="createProject" class="bg-white dark:bg-neutral-800 rounded-lg w-full max-w-3xl p-6 mx-4">
        <div class="flex items-start justify-between">
            <h1 class="text-xl font-bold"> Add Project </h1>

            {{-- Cross button calls JS fn and resets Livewire form --}}
            <button type="button" wire:click="showAddProjectsForm" class="ml-3">
                <i class="bi bi-x-lg text-red-500 cursor-pointer"></i>
            </button>
        </div>

        <hr class="text-neutral-300 dark:bg-neutral-700 my-4">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            {{-- Project Name --}}
            <div>
                <x-input-field model="name" type="text" placeholder="Enter project name" label="Project Name"
                    required />
                @error('name')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Project Value --}}
            <div>
                <x-input-field model="value" type="number" step="0.01" placeholder="1500.00" label="Project Value"
                    required />
                @error('value')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description (full width on small, spans 2 on large) --}}
            <div class="col-span-1 lg:col-span-2">
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Project
                    Description</label>
                <textarea wire:model.defer="description" placeholder="Project details..."
                    class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150"></textarea>
                @error('description')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Client dropdown --}}
            <div>
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Client <span
                        class="text-red-500">*</span></label>
                <select wire:model.defer="client_id"
                    class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150">
                    <option value="">-- Select client --</option>
                    @foreach ($clients as $client)
                        <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status --}}
            <div>
                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Status <span
                        class="text-red-500">*</span></label>
                <select wire:model.defer="status"
                    class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 transition-all duration-150">
                    <option value="pending">Pending</option>
                    <option value="in-progress">In Progress</option>
                    <option value="completed">Completed</option>
                </select>
                @error('status')
                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                @enderror
            </div>

        </div>

        {{-- Buttons --}}
        <div class="mt-5 flex items-center justify-between">
            <div class="space-x-2">
                <button type="submit"
                    class="bg-blue-500 px-4 py-2 text-white rounded hover:bg-blue-600 cursor-pointer">Create</button>

                {{-- Cancel button: closes modal (JS fn) + resets Livewire form --}}
                <button type="button" wire:click="showAddProjectsForm"
                    class="bg-neutral-200 dark:bg-neutral-700 px-3 py-2 rounded hover:bg-neutral-300 dark:hover:bg-neutral-600">Cancel</button>
            </div>
        </div>
    </form>
</div>
