@props([
    'heading' => '',
    'value' => '',
    'dataOverTime' => '',
    'icon' => null,
    'dataColor' => 'text-green-600',
])

<div
    class="relative bg-white dark:bg-neutral-800 border border-neutral-200/70 dark:border-neutral-700 rounded-xl px-5 py-4 shadow-sm hover:shadow-md transition-shadow duration-200 dark:hover:shadow-neutral-700/70">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h3 class="lg:text-md text-xs font-semibold tracking-wide uppercase text-neutral-400 dark:text-neutral-500">
            {{ $heading }}
        </h3>

        <div class="text-neutral-400 dark:text-neutral-500 [&>svg]:h-4 [&>svg]:w-4 sm:[&>svg]:h-5 sm:[&>svg]:w-5">
            {!! $icon !!}
        </div>
    </div>

    <!-- Value -->
    <div class="mt-2">
        <p class="font-semibold tracking-tight text-2xl text-neutral-900 dark:text-neutral-100">
            {{ $value }}
        </p>
    </div>

    <!-- Delta / Meta -->
    <div class="mt-1">
        <p class="text-xs {{ $dataColor }}">
            {{ $dataOverTime }}
        </p>
    </div>
</div>
