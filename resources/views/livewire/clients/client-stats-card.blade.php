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
        @if (is_null($value))
            <!-- Skeleton -->
            <div class="h-6 w-24 bg-neutral-200 dark:bg-neutral-700 rounded animate-pulse"></div>
        @else
            <p class="font-semibold tracking-tight text-2xl text-neutral-900 dark:text-neutral-100">
                {{ number_format($value) }}
                {{-- {{ $value }} --}}
            </p>
        @endif
    </div>

    <!-- Meta -->
    <div class="mt-1">
        @if (is_null($dataOverTime))
            <div class="h-3 w-20 bg-neutral-200 dark:bg-neutral-700 rounded animate-pulse"></div>
        @else
            <p class="text-xs {{ $dataColor }}">
                {{ $dataOverTime }}
            </p>
        @endif
    </div>
</div>
