@props([
    'title' => 'Nothing here yet',
    'subtitle' => null,
])

<div class="flex flex-col items-center justify-center py-20 text-center">

    <!-- Icon -->
    <div class="mb-6 flex h-14 w-14 items-center justify-center rounded-xl
        bg-neutral-100 dark:bg-neutral-800">
        {{ $icon ?? '' }}
    </div>

    <!-- Title -->
    <h3 class="text-lg font-semibold text-neutral-900 dark:text-neutral-100">
        {{ $title }}
    </h3>

    <!-- Subtitle -->
    @if ($subtitle)
        <p class="mt-2 max-w-md text-sm text-neutral-500 dark:text-neutral-400">
            {{ $subtitle }}
        </p>
    @endif

</div>
