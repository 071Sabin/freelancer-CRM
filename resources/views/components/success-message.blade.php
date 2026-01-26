<div id="toast-{{ uniqid() }}"
    class="pointer-events-none fixed inset-0 z-[111] flex items-start justify-end px-4 py-6 sm:p-6">

    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 3000)" x-show="show" x-transition:enter="transform ease-out duration-300"
        x-transition:enter-start="translate-x-4 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
        x-transition:leave="transform ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
        x-transition:leave-end="translate-x-4 opacity-0"
        class="pointer-events-auto w-full max-w-sm overflow-hidden rounded-lg
                bg-white dark:bg-slate-700
                border-l-4 border-green-500
                shadow-lg dark:shadow-2xl
                ring-1 ring-black/5 dark:ring-white/15"
        role="alert" aria-live="assertive">

        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="h-6 w-6 text-green-500 dark:text-green-400" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>

                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900 dark:text-gray-100">
                        Success!
                    </p>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                        {{ $slot }}
                    </p>
                </div>

                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" @click="show = false"
                        class="inline-flex rounded-md
                               bg-white/70 dark:bg-slate-700
                               text-gray-400 dark:text-gray-300
                               hover:text-gray-600 dark:hover:text-white
                               focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 dark:focus:ring-offset-slate-700">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path
                                d="M6.28 5.22a.75.75 0 00-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 101.06 1.06L10 11.06l3.72 3.72a.75.75 0 101.06-1.06L11.06 10l3.72-3.72a.75.75 0 00-1.06-1.06L10 8.94 6.28 5.22z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
