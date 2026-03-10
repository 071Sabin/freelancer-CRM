{{-- @props(['projects']) --}}
@php
    $total = $tasks->count();
    $completed = $tasks->where('is_completed', true)->count();
    $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
@endphp
<div class="p-4 dark:bg-neutral-800 rounded-lg border border-neutral-200 dark:border-neutral-700">
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
            {{ $percentage }}%
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
        <h1 class="font-semibold text-lg">Tasks List</h1>
        @forelse ($tasks as $task)
            <div
                class="flex items-center justify-between p-3 bg-zinc-50 dark:bg-zinc-800/50 border border-zinc-200 dark:border-zinc-700 rounded-lg group transition-colors hover:bg-zinc-100 dark:hover:bg-zinc-800">

                <div class="flex items-center gap-3">
                    <flux:checkbox wire:click="toggleTask({{ $task->id }})" :checked="$task->is_completed" />

                    <span
                        class="text-sm font-medium transition-all duration-200 {{ $task->is_completed ? 'line-through text-zinc-400 dark:text-zinc-500' : 'text-zinc-800 dark:text-zinc-200' }}">
                        {{ $task->title }}
                    </span>
                </div>

                <flux:button wire:click="deleteTask({{ $task->id }})"
                    wire:confirm="Are you sure you want to delete this task?" variant="ghost" size="sm"
                    icon="trash"
                    class="opacity-0 group-hover:opacity-100 text-red-500 hover:text-red-700 transition-opacity" />
            </div>
        @empty
            <div class="text-center py-6 border-2 border-dashed border-zinc-200 dark:border-zinc-700 rounded-lg">
                <p class="text-sm text-zinc-500">No tasks added yet. Create one to start tracking progress.</p>
            </div>
        @endforelse
    </div>
</div>
