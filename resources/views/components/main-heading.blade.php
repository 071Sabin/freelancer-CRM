<div class="mb-6 sm:mb-8">
    <h1
        class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight
               text-gray-800 dark:text-gray-100">
        {{ $title }}
    </h1>

    @if (!empty($subtitle))
        <p class="mt-1 text-sm sm:text-base text-neutral-400">
            {{ $subtitle }}
        </p>
    @endif
</div>
