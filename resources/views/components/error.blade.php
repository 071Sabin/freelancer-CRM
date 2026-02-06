{{-- @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-md mb-4">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li> <br>
        @endforeach
    </div>
@endif --}}

@if ($errors->any())
    <div wire:key="error-toast-{{ time() }}" x-data="{
        show: true,
        init() {
            // Start the progress bar animation after a tiny delay to ensure render
            setTimeout(() => {
                this.$refs.progressBar.style.width = '0%';
            }, 50);
    
            // Auto-dismiss after 4 seconds
            setTimeout(() => {
                this.show = false;
            }, 4000);
        }
    }" x-show="show"
        x-transition:enter="transform ease-out duration-300 transition"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed top-4 left-4 right-4 md:left-auto md:right-6 z-[100] md:w-[400px] flex justify-end pointer-events-none">
        <div
            class="pointer-events-auto w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-2xl rounded-lg overflow-hidden relative ring-1 ring-black/5">

            <div class="absolute top-0 bottom-0 left-0 w-1 bg-red-500"></div>

            <div class="p-4 flex items-start gap-3">

                <div class="flex-shrink-0 mt-0.5">
                    <div class="h-8 w-8 rounded-full bg-red-100 dark:bg-red-900/30 flex items-center justify-center">
                        <svg class="h-5 w-5 text-red-600 dark:text-red-400" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                </div>

                <div class="flex-1">
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white">
                        Action Required
                    </h3>
                    <div class="mt-1 text-sm text-slate-500 dark:text-slate-400">
                        @if ($errors->count() > 1)
                            <ul class="list-disc list-inside space-y-1">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @else
                            <p>{{ $errors->first() }}</p>
                        @endif
                    </div>
                </div>

                <button @click="show = false"
                    class="flex-shrink-0 text-slate-400 hover:text-slate-500 dark:hover:text-slate-300 transition-colors focus:outline-none">
                    <span class="sr-only">Close</span>
                    <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <div x-ref="progressBar" class="absolute bottom-0 left-0 h-1 bg-red-500/50"
                style="width: 100%; transition: width 4000ms linear;"></div>

        </div>
    </div>
@endif
