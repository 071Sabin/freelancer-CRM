{{-- <div class="mb-6 sm:mb-8">
    <h1
        class="text-2xl sm:text-3xl lg:text-4xl font-bold tracking-tight
               text-neutral-800 dark:text-neutral-100">
        {{ $title }}
    </h1>

    @if (!empty($subtitle))
        <p class="mt-1 text-sm sm:text-base text-neutral-400">
            {{ $subtitle }}
        </p>
    @endif
</div> --}}


<div class="relative mb-8 lg:mb-10">
    <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4">
        <div class="max-w-3xl">
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-neutral-800 dark:text-neutral-100 leading-none">
                {{ $title }}
            </h1>

            @if (!empty($subtitle))
                <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400 font-medium leading-relaxed opacity-80">
                    {{ $subtitle }}
                </p>
            @endif
        </div>

        <div class="hidden sm:flex items-center gap-4 shrink-0 pb-1">
             <div class="flex flex-col items-end">
                <span class="text-[10px] font-bold text-neutral-400 uppercase tracking-widest opacity-60">Data Status</span>
                <div class="flex items-center gap-2 mt-0.5">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-500"></span>
                    </span>
                    <span class="text-xs font-semibold text-neutral-700 dark:text-neutral-300">Verified & Synced</span>
                </div>
             </div>
        </div>
    </div>

    <div class="mt-6 h-px w-full bg-gradient-to-r from-neutral-200 via-neutral-100 to-transparent dark:from-neutral-700 dark:via-neutral-800/50 dark:to-transparent"></div>
</div>