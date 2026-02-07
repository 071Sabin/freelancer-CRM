@props([
    'heading' => '',
    'value' => '',
    'dataOverTime' => '',
    'icon' => null,
    'dataColor' => 'text-green-600',
])

<div class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-800 rounded-xl p-4 shadow-sm">
    <div class="flex items-center justify-between">
        <h3 class="text-xs font-medium text-neutral-400 dark:text-gray-400 uppercase">{{ $heading }}</h3>
        {!! $icon !!}
    </div>
    <p class="text-3xl font-semibold text-gray-800 dark:text-gray-100 mt-2">
        {{ $value }}
    </p>
    <p class="text-xs {{ $dataColor }} mt-1">
        {{ $dataOverTime }}
    </p>
</div>
