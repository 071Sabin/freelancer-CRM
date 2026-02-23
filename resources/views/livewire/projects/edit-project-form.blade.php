<div class="bg-none">
    @if (session('success'))
        <x-success-message>
            {{ session('success') }}
        </x-success-message>
    @endif
    @if ($open)

        <div class="modal fixed inset-0 z-99 bg-black/50 backdrop-blur-md overflow-y-auto px-4 py-6">

            <div class="min-h-full flex items-start justify-center">

                <form wire:submit="saveProjectEdit"
                    class="bg-white dark:bg-neutral-800 rounded-lg
                   w-full max-w-3xl
                   p-5">

                    <h1 class="text-xl font-bold flex justify-between">
                        Edit Project Details
                        <button wire:click="closeEdit" type="button">
                            <i class="bi bi-x-lg text-red-500 cursor-pointer"></i>
                        </button>
                    </h1>

                    <x-hr-divider />

                    <div class="lg:grid grid-cols-2 gap-3 mb-3">

                        {{-- Project Name --}}
                        <x-input-field type="text" model="editProject.name" label="Project Name"
                            placeholder="Enter project name" required />

                        {{-- Project Value --}}
                        <x-input-field type="number" step="0.01" model="editProject.value" label="Project Value"
                            placeholder="1500.00" required />

                        {{-- Description (full width) --}}
                        <x-input-field type="textarea" model="editProject.description" label="Project Description"
                            placeholder="Project details..." class="col-span-2" />

                        {{-- Client --}}
                        <div>
                            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Client <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="editProject.client_id"
                                class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"
                                required>
                                <option value="">-- Select Client --</option>
                                @foreach ($clients as $client)
                                    <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                                @endforeach
                            </select>
                            @error('editProject.client_id')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div>
                            <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select wire:model="editProject.status"
                                class="mt-2 w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-all duration-150"
                                required>
                                <option value="active">Active</option>
                                <option value="in-progress">In Progress</option>
                                <option value="on-hold">On Hold</option>
                                <option value="completed">Completed</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                            @error('editProject.status')
                                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <x-primary-button type="submit">Save</x-primary-button>

                    <flux:text wire:dirty class="text-amber-500 text-sm font-medium animate-pulse">
                        Unsaved changes...
                    </flux:text>

                </form>

            </div>
        </div>
    @elseif($showDetails)
        <div class="modal fixed inset-0 z-99 bg-black/50 backdrop-blur-md overflow-y-auto px-4 py-6">
            <div class="min-h-full flex items-start justify-center">
                <div
                    class="w-full max-w-3xl rounded-xl shadow-xl bg-white text-stone-800 border border-stone-200 dark:bg-neutral-800 dark:text-neutral-100 dark:border-neutral-700">


                    {{-- Header --}}
                    <div
                        class="flex items-center justify-between px-6 py-4
                    border-b border-stone-200 dark:border-neutral-700">
                        <h2 class="text-lg font-semibold text-stone-800 dark:text-neutral-100">
                            Project Details
                        </h2>

                        <button wire:click="closeView" class="text-neutral-400 hover:text-red-500 cursor-pointer"
                            aria-label="Close">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>

                    {{-- Body --}}
                    <div class="px-6 py-6 space-y-6">

                        {{-- Deleted Warning --}}
                        @if (!empty($viewProject['deleted_at']))
                            <div
                                class="rounded-md px-4 py-3 text-sm
                           bg-red-50 text-red-700 border border-red-300
                           dark:bg-red-900/30 dark:text-red-300 dark:border-red-500">
                                ⚠️ This project has been deleted.
                            </div>
                        @endif

                        {{-- Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-5">

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Project
                                    Name</p>
                                <p class="mt-1 text-sm font-medium text-stone-800 dark:text-neutral-100">
                                    {{ $viewProject['name'] }}
                                </p>
                            </div>
                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Project
                                    Value</p>
                                <p class="mt-1 text-sm font-medium text-stone-800 dark:text-neutral-100">
                                    {{ $viewProject['value'] }}
                                </p>
                            </div>

                            <div>
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">Status
                                </p>

                                @php
                                    $statusColors = [
                                        'completed' => 'bg-green-100 text-green-700 border border-green-400
                                 dark:bg-green-900/30 dark:text-green-300 dark:border-green-500',

                                        'pending' => 'bg-red-100 text-red-700 border border-red-400
                                 dark:bg-red-900/30 dark:text-red-300 dark:border-red-500',

                                        'in-progress' => 'bg-amber-100 text-amber-700 border border-amber-400
                                 dark:bg-amber-900/30 dark:text-amber-300 dark:border-amber-500',
                                    ];
                                @endphp

                                <span
                                    class="inline-flex items-center mt-1 px-3 py-1 rounded-full text-xs font-semibold
                               {{ $statusColors[$viewProject['status']] ?? 'bg-stone-100 text-stone-700 dark:bg-neutral-700 dark:text-neutral-300' }}">
                                    {{ ucfirst($viewProject['status']) }}
                                </span>
                            </div>

                            <div class="md:col-span-2">
                                <p class="text-xs uppercase tracking-wide text-stone-500 dark:text-neutral-400">
                                    Description</p>
                                <p class="mt-1 text-sm text-stone-700 dark:text-neutral-200 whitespace-pre-line">
                                    {{ $viewProject['description'] ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Footer --}}
                    <div class="px-6 py-4 border-t border-stone-200 dark:border-neutral-700 flex justify-end">
                        <x-secondary-button wire:click="$set('showDetails', false)">close</x-secondary-button>
                    </div>
                </div>
            </div>

        </div>
    @endif
</div>
