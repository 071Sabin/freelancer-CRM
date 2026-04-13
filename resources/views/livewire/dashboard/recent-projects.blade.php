<div wire:init="$refresh">

    <div
        class="lg:col-span-2 flex flex-col h-full bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700/50 rounded-xl shadow-sm overflow-hidden relative">

        <!-- Header -->
        <div class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-700/50 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <svg class="w-5 h-5 text-neutral-400 dark:text-neutral-500" fill="none" viewBox="0 0 24 24"
                    stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.25 12.75V12A2.25 2.25 0 0 1 4.5 9.75h15A2.25 2.25 0 0 1 21.75 12v.75m-8.69-6.44-2.12-2.12a1.5 1.5 0 0 0-1.061-.44H4.5A2.25 2.25 0 0 0 2.25 6v12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 18V9a2.25 2.25 0 0 0-2.25-2.25h-5.379a1.5 1.5 0 0 1-1.06-.44Z" />
                </svg>
                <h2 class="text-base font-semibold text-neutral-900 dark:text-white">
                    Recent Projects
                </h2>
            </div>

            <a href="{{ route('projects') }}" wire:navigate
                class="text-xs font-medium text-neutral-500 hover:text-indigo-600 dark:text-neutral-400 dark:hover:text-white">
                View All &rarr;
            </a>
        </div>

        <!-- Content -->
        <div class="flex-1 overflow-y-auto relative">

            <!-- Skeleton -->
            <div wire:loading.delay class="absolute inset-0 px-6 py-4 space-y-4">

                @for ($i = 0; $i < (count($recentProjects)); $i++)
                    <div class="flex items-center justify-between animate-pulse">

                        <div class="flex items-center gap-4 w-full min-w-0">

                            <!-- Avatar (ALWAYS visible for layout consistency) -->
                            <div class="h-10 w-10 flex-none rounded-lg bg-neutral-200 dark:bg-neutral-700"></div>

                            <!-- Text -->
                            <div class="flex-1 space-y-2 min-w-0">
                                <div class="h-3 w-1/2 sm:w-1/3 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                                <div class="h-2 w-1/3 sm:w-1/4 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                            </div>
                        </div>

                        <!-- Badge -->
                        <div class="h-5 w-12 sm:w-16 bg-neutral-200 dark:bg-neutral-700 rounded"></div>
                    </div>
                @endfor

            </div>

            <!-- Real Data -->
            <div wire:loading.remove>
                <ul class="divide-y divide-neutral-100 dark:divide-neutral-700/50">
                    @foreach ($recentProjects as $rp)
                        <li class="group relative">
                            <a href="#"
                                class="flex items-center justify-between p-4 sm:px-6 hover:bg-neutral-50 dark:hover:bg-neutral-700/40">

                                <div class="flex items-center gap-4 min-w-0">
                                    <div
                                        class="h-10 w-10 flex-none flex items-center justify-center rounded-lg bg-neutral-100 dark:bg-neutral-700/50 border border-neutral-200 dark:border-neutral-600 text-neutral-500 dark:text-neutral-400">
                                        <span class="text-xs font-bold uppercase">
                                            {{ substr($rp->name, 0, 2) }}
                                        </span>
                                    </div>

                                    <div class="min-w-0 flex-auto">
                                        <p
                                            class="text-sm font-semibold text-neutral-900 dark:text-white truncate group-hover:text-indigo-600 dark:group-hover:text-indigo-400">
                                            {{ $rp->name }}
                                        </p>

                                        <div class="flex items-center gap-2 mt-0.5">
                                            <svg class="w-3 h-3 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                            </svg>

                                            <p class="text-xs text-neutral-500 dark:text-neutral-400 truncate">
                                                {{ $rp->client->client_name ?? 'Unknown Client' }}
                                            </p>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex items-center gap-4">
                                    <x-badges.project-status project_status="{{ $rp->status }}" />
                                </div>

                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>