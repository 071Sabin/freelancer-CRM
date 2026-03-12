@props(['project_status'])

@php
    $map = [
        'active' => [
            'label' => 'Active',
            'classes' =>
                'bg-blue-50 text-blue-700 ring-blue-700/10 dark:bg-blue-400/10 dark:text-blue-400 dark:ring-blue-400/30',
        ],

        'in_progress' => [
            'label' => 'In Progress',
            'classes' =>
                'bg-amber-50 text-amber-700 ring-amber-600/20 dark:bg-amber-400/10 dark:text-amber-400 dark:ring-amber-400/30',
        ],

        'on_hold' => [
            'label' => 'On Hold',
            'classes' =>
                'bg-neutral-50 text-neutral-600 ring-neutral-500/10 dark:bg-neutral-400/10 dark:text-neutral-400 dark:ring-neutral-400/20',
        ],

        'completed' => [
            'label' => 'Completed',
            'classes' =>
                'bg-emerald-50 text-emerald-700 ring-emerald-600/20 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/30',
        ],

        'cancelled' => [
            'label' => 'Cancelled',
            'classes' =>
                'bg-rose-50 text-rose-700 ring-rose-600/10 dark:bg-rose-400/10 dark:text-rose-400 dark:ring-rose-400/30',
        ],
    ];

    $project_statusData = $map[$project_status] ?? null;
@endphp


@if ($project_statusData)
    <span
        class="inline-flex items-center px-2 py-1 text-xs font-medium rounded-md ring-1 ring-inset {{ $project_statusData['classes'] }}">
        {{ $project_statusData['label'] }}
    </span>
@else
    <span class="text-xs text-neutral-500">
        Unknown
    </span>
@endif
