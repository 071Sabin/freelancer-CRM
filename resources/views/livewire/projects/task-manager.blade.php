{{-- @props(['projects']) --}}

@php
    $total = $tasks->count();
    $completed = $tasks->where('is_completed', true)->count();
    $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
@endphp

<div class="p-4 dark:bg-neutral-800 rounded-lg border shadow-sm border-neutral-200 dark:border-neutral-700">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3 mb-4">

        {{-- LEFT --}}
        <div class="min-w-0">
            <h2 class="text-base sm:text-lg font-semibold text-neutral-900 dark:text-neutral-100">
                Project Tasks & Milestones
            </h2>

            <p class="text-sm text-neutral-500 mt-0.5 max-w-md">
                Manage tasks to automatically update the client's progress bar.
            </p>
        </div>


        {{-- RIGHT (PROGRESS) --}}
        <div class="flex items-center gap-2 sm:flex-col sm:items-end sm:text-right shrink-0">
            <span class="text-lg sm:text-xl font-semibold text-blue-600 dark:text-blue-400">
                {{ $percentage ?? 0 }}%
            </span>
            <span class="text-[10px] sm:text-xs uppercase tracking-wide text-neutral-500">
                Progress
            </span>
        </div>

    </div>

    <form wire:submit.prevent="addTask"
        class="mb-8 overflow-hidden rounded-xl bg-white dark:bg-neutral-900/50 border border-neutral-200 dark:border-neutral-700">

        <div class="p-4 sm:p-5 space-y-5">
            <x-input-field type="text" model="newTaskTitle" placeholder="e.g., Setup database schema..."
                label="Task Title" required />
            <x-input-field type="text" model="newTaskDesc" placeholder="Add necessary context or instructions..."
                label="Task Description" />

            {{-- NEW: Visible to Client Checkbox in Form --}}
            <div class="pt-2">
                <flux:checkbox wire:model="newTaskVisible" label="Visible to Client Portal"
                    description="Show this task as a milestone to the client." />
            </div>
        </div>

        <div
            class="flex flex-col-reverse sm:flex-row sm:items-center justify-between gap-3 bg-neutral-50/80 dark:bg-neutral-800/40 px-4 sm:px-5 py-3 border-t border-neutral-200 dark:border-neutral-800">

            <div class="hidden sm:flex items-center text-xs font-medium text-neutral-500 dark:text-neutral-400">
                <svg class="size-4 mr-1.5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                </svg>
                Hit <kbd
                    class="mx-1 rounded border border-neutral-300 dark:border-neutral-600 bg-white dark:bg-neutral-800 px-1.5 py-0.5 font-sans font-semibold text-neutral-600 dark:text-neutral-300">Enter</kbd>
                to save quickly
            </div>

            <x-primary-button type="submit" class="w-full sm:w-auto inline-flex justify-center items-center shadow-sm">
                <flux:icon.plus class="size-4 mr-1.5" />
                Add Task
            </x-primary-button>
        </div>
    </form>

    <x-hr-divider />

    <div class="space-y-2">
        @if ($tasks && $tasks->count() > 0)
            <h1 class="font-semibold text-lg text-neutral-800 dark:text-neutral-200">Tasks List</h1>
        @endif

        @forelse ($tasks as $task)
            <div
                class="group flex items-start justify-between gap-3 p-3 sm:p-4 bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-800 transition-colors focus-within:ring-2 focus-within:ring-blue-500 focus-within:border-transparent">

                {{-- Content Container --}}
                <div class="flex items-start gap-3 min-w-0 flex-1">

                    {{-- Checkbox --}}
                    <flux:checkbox wire:click="toggleTask({{ $task->id }})" :checked="$task->is_completed"
                        class="mt-1 shrink-0" />

                    {{-- Task Details --}}
                    <div class="flex flex-col min-w-0">
                        <span
                            class="font-medium text-sm sm:text-base truncate {{ $task->is_completed ? 'line-through text-zinc-400' : 'text-zinc-800 dark:text-zinc-200' }}"
                            title="{{ $task->title }}">
                            {{ $task->title }}
                        </span>

                        @if ($task->description)
                            <span class="text-xs sm:text-sm text-zinc-500 dark:text-zinc-400 line-clamp-2 mt-0.5"
                                title="{{ $task->description }}">
                                {{ $task->description }}
                            </span>
                        @endif

                        {{-- Client Visible Badge (Redesigned for modern SaaS UI) --}}
                        @if ($task->is_visible_to_client)
                            <span
                                class="mt-2 w-max inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full bg-blue-50 dark:bg-blue-900/30 text-[10px] font-semibold text-blue-600 dark:text-blue-400 uppercase tracking-wider border border-blue-100 dark:border-blue-800/50">
                                <flux:icon.eye class="size-3" /> Client Visible
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons --}}
                {{-- UX Fix: opacity-100 on mobile, hover/focus reveal on sm and above --}}
                <div
                    class="flex items-center gap-1 shrink-0 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 focus-within:opacity-100 transition-opacity duration-200">

                    <flux:button wire:click="toggleVisibility({{ $task->id }})" variant="ghost" size="sm"
                        icon="{{ $task->is_visible_to_client ? 'eye-slash' : 'eye' }}"
                        class="text-zinc-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                        title="{{ $task->is_visible_to_client ? 'Hide from Client' : 'Show to Client' }}"
                        aria-label="{{ $task->is_visible_to_client ? 'Hide task from client' : 'Show task to client' }}" />

                    <flux:button wire:click="deleteTask({{ $task->id }})"
                        wire:confirm="Are you sure you want to delete this task?" variant="ghost" size="sm"
                        icon="trash"
                        class="text-zinc-400 hover:text-red-600 dark:hover:text-red-400 transition-colors"
                        aria-label="Delete task" />
                </div>
            </div>
        @empty
            <div class="text-center py-6 border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-lg">
                <p class="text-sm text-zinc-500">No tasks added yet. Create one to start tracking progress.</p>
            </div>
        @endforelse
    </div>
</div>
