<div 
    wire:ignore 
    wire:key="notify-error" 
    x-data="{ 
        show: false,
        init() {
            {{-- Reset progress bar on mount --}}
            if(this.$refs.progressBar) this.$refs.progressBar.style.width = '100%';
        }
    }"
    x-on:notify-error.window="
        show = true;
        $nextTick(() => {
            if($refs.progressBar) {
                $refs.progressBar.style.transition = 'none';
                $refs.progressBar.style.width = '100%';
                setTimeout(() => {
                    $refs.progressBar.style.transition = 'width 4000ms linear';
                    $refs.progressBar.style.width = '0%';
                }, 50);
            }
        });
        setTimeout(() => { show = false; }, 4000);
    "
    x-show="show"
    x-transition:enter="transform ease-out duration-300 transition"
    x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-10"
    x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
    x-transition:leave="transition ease-in duration-500"
    x-transition:leave-start="opacity-100"
    x-transition:leave-end="opacity-0 translate-x-20"
    class="fixed top-6 right-6 z-[100] w-full max-w-[400px] pointer-events-none"
    style="display: none;"
>
    <div class="pointer-events-auto relative overflow-hidden rounded-xl bg-white dark:bg-slate-900 shadow-[0_20px_50px_rgba(0,0,0,0.15)] ring-1 ring-slate-200 dark:ring-slate-800">
        
        {{-- Decorative accent side-bar --}}
        <div class="absolute top-0 bottom-0 left-0 w-1.5 bg-red-600"></div>

        <div class="p-5">
            <div class="flex items-start gap-4">
                {{-- High-End Icon Graphic --}}
                <div class="flex-shrink-0">
                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-red-50 dark:bg-red-900/20 ring-8 ring-red-50/50 dark:ring-red-900/10">
                        <svg class="h-6 w-6 text-red-600 dark:text-red-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                </div>

                <div class="flex-1 pt-0.5">
                    <h3 class="text-sm font-bold tracking-tight text-slate-900 dark:text-white">
                        Validation Failed
                    </h3>
                    
                    <div class="mt-2 space-y-1.5">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
                                    <span class="h-1 w-1 rounded-full bg-red-400"></span>
                                    <p>{{ $error }}</p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-sm text-slate-600 dark:text-slate-400 italic">Critical system error occurred.</p>
                        @endif
                    </div>
                </div>

                {{-- Close Button --}}
                <div class="flex-shrink-0">
                    <button @click="show = false" class="inline-flex rounded-md p-1.5 text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 transition-all focus:outline-none">
                        <span class="sr-only">Dismiss</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        {{-- Smooth Progress Bar --}}
        <div class="absolute bottom-0 left-0 right-0 h-[3px] bg-slate-100 dark:bg-slate-800">
            <div 
                x-ref="progressBar" 
                class="h-full bg-gradient-to-r from-red-500 to-red-600 shadow-[0_0_10px_rgba(220,38,38,0.5)]"
                style="width: 100%;">
            </div>
        </div>
    </div>
</div>