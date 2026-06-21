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

    @if ($runningTimer)
        <div class="mb-4 flex items-center justify-between px-3 py-1.5 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg text-xs shrink-0 shadow-sm">
            <div class="flex items-center gap-2 text-neutral-600 dark:text-neutral-400">
                <flux:icon.clock class="size-3.5 text-red-500 shrink-0" />
                <span>
                    Active: <strong class="text-neutral-850 dark:text-neutral-100 font-semibold">{{ $runningTimer->task->title ?? 'General Tasks' }}</strong>
                </span>
                <span class="tabular-nums font-semibold text-neutral-800 dark:text-white" x-data="{ 
                    start: {{ $runningTimer->start_time->timestamp }}, 
                    now: Math.floor(Date.now() / 1000),
                    format(sec) {
                        let h = Math.floor(sec / 3600).toString().padStart(2, '0');
                        let m = Math.floor((sec % 3600) / 60).toString().padStart(2, '0');
                        let s = (sec % 60).toString().padStart(2, '0');
                        return `${h}:${m}:${s}`;
                    }
                }" x-init="setInterval(() => now = Math.floor(Date.now() / 1000), 1000)">
                    (<span x-text="format(now - start)"></span>)
                </span>
            </div>
            <flux:button wire:click="stopTimer({{ $runningTimer->task_id }})" size="xs" variant="ghost" class="text-red-600 hover:text-red-705 dark:text-red-400 text-[10px] font-semibold py-0 px-2 h-6 min-h-0">
                Stop
            </flux:button>
        </div>
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

            {{-- Time Logs Invoice Trigger --}}
            @php
                $unbilledDuration = \App\Models\TimeLog::where('project_id', $project->id)->where('is_billed', false)->whereNotNull('end_time')->sum('duration_seconds');
                $unbilledHours = round($unbilledDuration / 3600, 2);
            @endphp
            @if ($unbilledHours > 0)
                <div class="mt-2 flex items-center gap-2">
                    <span class="inline-flex items-center rounded-md bg-amber-50 px-2 py-1 text-xs font-semibold text-amber-800 ring-1 ring-inset ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/20">
                        {{ $unbilledHours }} Unbilled Hours
                    </span>
                    <flux:button wire:click="billTimeLogs" variant="filled" size="sm" class="text-xs bg-amber-600 hover:bg-amber-700 text-white border-none">
                        Invoice Hours
                    </flux:button>
                </div>
            @endif
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
            @php
                $taskLoggedSeconds = \App\Models\TimeLog::where('task_id', $task->id)->whereNotNull('end_time')->sum('duration_seconds');
                $h = floor($taskLoggedSeconds / 3600);
                $m = floor(($taskLoggedSeconds % 3600) / 60);
                $taskTimeFormatted = "{$h}h {$m}m";
                $isCurrentRunning = $runningTimer && $runningTimer->task_id === $task->id;
            @endphp
            <div
                class="group flex items-center justify-between gap-3 p-2.5 sm:p-3 bg-neutral-50 dark:bg-neutral-800/50 border border-neutral-200 dark:border-neutral-700 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors focus-within:ring-1 focus-within:ring-neutral-400">

                {{-- Content Container --}}
                <div class="flex items-start gap-2.5 min-w-0 flex-1">

                    {{-- Checkbox --}}
                    <flux:checkbox wire:click="toggleTask({{ $task->id }})" :checked="$task->is_completed"
                        class="mt-1 shrink-0" />

                    {{-- Task Details --}}
                    <div class="flex flex-col min-w-0 flex-1">
                        <span
                            class="font-semibold text-sm truncate {{ $task->is_completed ? 'line-through text-neutral-450' : 'text-neutral-850 dark:text-neutral-200' }}"
                            title="{{ $task->title }}">
                            {{ $task->title }}
                        </span>

                        @if ($task->description)
                            <span class="text-[11px] text-neutral-500 dark:text-neutral-400 line-clamp-2 mt-0.5"
                                title="{{ $task->description }}">
                                {{ $task->description }}
                            </span>
                        @endif

                        <div class="mt-1.5 flex flex-wrap gap-1.5 items-center">
                            {{-- Clock Badge (Always Shown) --}}
                            <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-neutral-200/60 dark:bg-neutral-750/70 text-[9px] font-bold text-neutral-600 dark:text-neutral-350 uppercase tracking-wider">
                                <flux:icon.clock class="size-3" /> {{ $taskTimeFormatted }}
                            </span>

                            @if ($task->is_visible_to_client)
                                <span
                                    class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-blue-50 dark:bg-blue-900/30 text-[9px] font-bold text-blue-600 dark:text-blue-450 uppercase tracking-wider border border-blue-100 dark:border-blue-800/40">
                                    <flux:icon.eye class="size-3" /> Client Visible
                                </span>
                                
                                @if ($task->client_status === 'approved')
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-emerald-50 dark:bg-emerald-900/30 text-[9px] font-bold text-emerald-600 dark:text-emerald-450 uppercase tracking-wider border border-emerald-100 dark:border-emerald-800/40">
                                        Approved
                                    </span>
                                @elseif ($task->client_status === 'revision_requested')
                                    <span class="inline-flex items-center gap-1 px-1.5 py-0.5 rounded bg-rose-50 dark:bg-rose-900/30 text-[9px] font-bold text-rose-600 dark:text-rose-450 uppercase tracking-wider border border-rose-100 dark:border-rose-800/40">
                                        Revision Req.
                                    </span>
                                @endif
                            @endif
                        </div>

                        @if ($task->is_visible_to_client && $task->client_status === 'revision_requested' && $task->client_feedback)
                            <div class="mt-1.5 text-[11px] text-rose-700 bg-rose-50/50 dark:bg-rose-950/10 rounded px-2 py-1 border border-rose-200/40 max-w-md">
                                <strong>Client Note:</strong> {{ $task->client_feedback }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Time Tracking Actions --}}
                <div class="flex items-center gap-1.5 mr-1.5 shrink-0">
                    @if ($isCurrentRunning)
                        <flux:button wire:click="stopTimer({{ $task->id }})" variant="danger" size="sm" class="!size-7 sm:!size-8 [&>svg]:size-3.5 sm:[&>svg]:size-4" icon="stop" title="Stop Timer" />
                    @else
                        <flux:button wire:click="startTimer({{ $task->id }})" variant="ghost" size="sm" class="!size-7 sm:!size-8 [&>svg]:size-3.5 sm:[&>svg]:size-4 text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/20" icon="play" title="Start Timer" />
                    @endif
                </div>

                {{-- Action Buttons --}}
                {{-- UX Fix: opacity-100 on mobile, hover/focus reveal on sm and above --}}
                <div
                    class="flex items-center gap-1 sm:gap-1.5 shrink-0 opacity-100 sm:opacity-0 sm:group-hover:opacity-100 focus-within:opacity-100 transition-opacity duration-200 font-sans">

                    {{-- Toggle Visibility --}}
                    <flux:button wire:click="toggleVisibility({{ $task->id }})" variant="ghost"
                        icon="{{ $task->is_visible_to_client ? 'eye-slash' : 'eye' }}"
                        class="!size-7 sm:!size-8 [&>svg]:size-3.5 sm:[&>svg]:size-4 text-neutral-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors"
                        title="{{ $task->is_visible_to_client ? 'Hide from Client' : 'Show to Client' }}"
                        aria-label="{{ $task->is_visible_to_client ? 'Hide task from client' : 'Show task to client' }}" />

                    {{-- Edit Task --}}
                    <flux:button wire:click="editTask({{ $task->id }})" variant="ghost" icon="pencil"
                        class="!size-7 sm:!size-8 [&>svg]:size-3.5 sm:[&>svg]:size-4 text-neutral-400 hover:text-blue-500 transition-colors"
                        aria-label="Edit task" />

                    {{-- Delete Task (Moved to the far right for safety) --}}
                    <flux:button wire:click="deleteTask({{ $task->id }})"
                        wire:confirm="Are you sure you want to delete this task?" variant="ghost" icon="trash"
                        class="!size-7 sm:!size-8 [&>svg]:size-3.5 sm:[&>svg]:size-4 text-neutral-400 hover:text-red-600 dark:hover:text-red-400 transition-colors"
                        aria-label="Delete task" />

                </div>
            </div>
        @empty
            <div class="text-center py-6 border-2 border-dashed border-neutral-200 dark:border-neutral-700 rounded-lg">
                <p class="text-sm text-neutral-500">No tasks added yet. Create one to start tracking progress.</p>
            </div>
        @endforelse

        {{-- Edit Task Modal --}}
        <flux:modal name="edit-task-modal" class="md:w-96">
            <form wire:submit.prevent="updateTask" class="space-y-4">

                <div>
                    <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">Edit Task</h3>
                    <p class="text-sm text-neutral-500">Update your milestone details.</p>
                </div>

                <div class="space-y-4">
                    <x-input-field type="text" model="editTaskTitle" label="Task Title" required />
                    <x-input-field type="text" model="editTaskDesc" label="Task Description" />

                    <div class="pt-2">
                        <flux:checkbox wire:model="editTaskVisible" label="Visible to Client" />
                    </div>
                </div>

                <div class="flex justify-end gap-2 pt-4 border-t border-neutral-200 dark:border-neutral-700">
                    <flux:modal.close>
                        <flux:button variant="ghost">Cancel</flux:button>
                    </flux:modal.close>
                    <x-primary-button type="submit">Save Changes</x-primary-button>
                </div>

            </form>
        </flux:modal>
    </div>
</div>
