{{-- <div id="toast-{{ uniqid() }}"
     class="pointer-events-none fixed inset-0 z-[111] flex items-start justify-end p-6">

    <div 
        x-data="{
            show: true,
            duration: 4200,
            init() {
                setTimeout(() => this.show = false, this.duration)
            }
        }"
        x-show="show"
        x-transition:enter="transform ease-[cubic-bezier(.16,1,.3,1)] duration-500"
        x-transition:enter-start="translate-x-6 opacity-0 scale-95"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100"
        x-transition:leave="transform ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-4"
        class="pointer-events-auto w-full max-w-sm">

        <div class="relative overflow-hidden rounded-xl
                    bg-white dark:bg-slate-900
                    border border-slate-200 dark:border-slate-700
                    shadow-[0_10px_30px_-10px_rgba(0,0,0,0.25)]
                    dark:shadow-[0_10px_30px_-10px_rgba(0,0,0,0.6)]
                    ring-1 ring-black/5 dark:ring-white/10"
             role="alert"
             aria-live="assertive">

            <div class="p-4">
                <div class="flex items-start gap-3">

                    <!-- Icon -->
                    <div class="flex items-center justify-center
                                h-9 w-9 rounded-full
                                bg-emerald-50 dark:bg-emerald-900/30">
                        <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke-width="2"
                             stroke="currentColor">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <p class="text-sm font-semibold
                                  text-slate-900 dark:text-slate-100">
                            Success
                        </p>

                        <p class="mt-1 text-sm leading-relaxed
                                  text-slate-600 dark:text-slate-400">
                            {{ $slot }}
                        </p>
                    </div>

                    <!-- Close -->
                    <button @click="show = false"
                            class="rounded-md p-1.5
                                   text-slate-400
                                   hover:text-slate-600
                                   dark:hover:text-slate-200
                                   hover:bg-slate-100
                                   dark:hover:bg-slate-800
                                   transition
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-emerald-500/40">
                        <svg class="h-4 w-4"
                             viewBox="0 0 20 20"
                             fill="currentColor">
                            <path fill-rule="evenodd"
                                  d="M4.293 4.293a1 1 0 011.414 0L10 
                                     8.586l4.293-4.293a1 1 0 
                                     111.414 1.414L11.414 10l4.293 
                                     4.293a1 1 0 01-1.414 
                                     1.414L10 11.414l-4.293 
                                     4.293a1 1 0 
                                     01-1.414-1.414L8.586 10 
                                     4.293 5.707a1 1 0 
                                     010-1.414z"
                                  clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Premium Progress Indicator -->
            <div class="absolute bottom-0 left-0 h-[2px] w-full bg-slate-200 dark:bg-slate-700">
                <div class="h-full bg-emerald-500 dark:bg-emerald-400"
                     x-bind:style="`animation: toast-progress ${duration}ms linear forwards`">
                </div>
            </div>

        </div>
    </div>
</div>

<style>
@keyframes toast-progress {
    from { width: 100%; }
    to { width: 0%; }
}
</style> --}}



<div id="toast-{{ uniqid() }}" class="pointer-events-none fixed inset-0 z-[111] flex items-start justify-end p-6">

    <div x-data="{
        show: true,
        duration: 4200,
        init() {
            setTimeout(() => this.show = false, this.duration)
        }
    }" x-show="show" x-transition:enter="transform ease-[cubic-bezier(.16,1,.3,1)] duration-500"
        x-transition:enter-start="translate-x-6 opacity-0 scale-95"
        x-transition:enter-end="translate-x-0 opacity-100 scale-100" x-transition:leave="transform ease-in duration-300"
        x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-4"
        class="pointer-events-auto w-full max-w-sm">

        <div class="relative overflow-hidden rounded-xl
                    bg-white dark:bg-neutral-900
                    border border-neutral-200 dark:border-neutral-700
                    border-l-[3px] border-l-emerald-500 dark:border-l-emerald-400
                    shadow-[0_10px_28px_-10px_rgba(0,0,0,0.18)]
                    dark:shadow-[0_10px_28px_-10px_rgba(0,0,0,0.5)]
                    ring-1 ring-black/5 dark:ring-white/10"
            role="alert" aria-live="assertive">

            <div class="px-4 py-3">
                <div class="flex items-start gap-3">

                    <!-- Small Success Icon -->
                    <div class="mt-[2px]">
                        <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none" viewBox="0 0 24 24"
                            stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <p class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                            Success
                        </p>

                        <p class="mt-0.5 text-xs md:text-sm text-neutral-600 dark:text-neutral-400 leading-relaxed">
                            {{ $slot }}
                        </p>
                    </div>

                    <!-- Close Button -->
                    <button @click="show = false"
                        class="rounded-md p-1
                                   text-neutral-400
                                   hover:text-neutral-600
                                   dark:hover:text-neutral-200
                                   hover:bg-neutral-100
                                   dark:hover:bg-neutral-800
                                   transition
                                   focus:outline-none
                                   focus:ring-2
                                   focus:ring-emerald-500/40">
                        <svg class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10
                                     8.586l4.293-4.293a1 1 0
                                     111.414 1.414L11.414 10l4.293
                                     4.293a1 1 0 01-1.414
                                     1.414L10 11.414l-4.293
                                     4.293a1 1 0
                                     01-1.414-1.414L8.586 10
                                     4.293 5.707a1 1 0
                                     010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>

                </div>
            </div>

            <!-- Refined Progress Indicator -->
            <div class="absolute bottom-0 left-0 h-[2px] w-full bg-neutral-200 dark:bg-neutral-700">
                <div class="h-full bg-emerald-500 dark:bg-emerald-400"
                    x-bind:style="`animation: toast-progress ${duration}ms linear forwards`">
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    @keyframes toast-progress {
        from {
            width: 100%;
        }

        to {
            width: 0%;
        }
    }
</style>
