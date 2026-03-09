{{-- @props(['projects']) --}}

<div class="p-6">
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif

    @if (session('warning'))
        <x-notification type="warning">{{ session('warning') }}</x-notification>
    @endif

    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif

    <div class="flex items-center justify-between mb-4">
        <div>
            <flux:heading size="lg">Project Tasks & Milestones</flux:heading>
            <flux:subheading>Manage tasks to automatically update the client's progress bar.</flux:subheading>
        </div>

        @php
            $total = $tasks->count();
            $completed = $tasks->where('is_completed', true)->count();
            $percentage = $total > 0 ? round(($completed / $total) * 100) : 0;
        @endphp

        <div class="text-right">
            <span class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $percentage }}%</span>
            <p class="text-xs text-zinc-500 uppercase tracking-wide">Progress</p>
        </div>
    </div>

    <form wire:submit.prevent="addTask" class="flex items-center gap-2 mb-6">
        <div class="flex-1">
            <flux:input wire:model="newTaskTitle" placeholder="e.g., Setup Database Schema..." required />
        </div>
        <flux:button type="submit" variant="primary" icon="plus">Add Task</flux:button>
    </form>

    <div class="space-y-2">
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
