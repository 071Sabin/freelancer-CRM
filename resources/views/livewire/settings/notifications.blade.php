<div>
    <x-main-heading title="Notification Center" subtitle="Manage your frequency and preferred channels for updates." />

    <div class="mt-6 space-y-6">
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
            <form action="#" method="POST">
                <div class="p-6 sm:p-8 space-y-8">
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3 mb-2">
                            <h3 class="text-xs font-bold tracking-widest text-neutral-500 dark:text-neutral-400 uppercase">
                                Email Channels
                            </h3>
                            <span class="text-[10px] px-2 py-0.5 bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold rounded-full uppercase tracking-wider">Active</span>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Account Activity -->
                            <div class="p-4 sm:p-5 rounded-xl border border-neutral-200 dark:border-neutral-800 flex flex-col justify-start gap-1 transition-colors hover:border-neutral-300 dark:hover:border-neutral-700 h-full bg-transparent">
                                <div class="flex items-center justify-between gap-2">
                                    <label for="notif-activity" class="text-sm font-semibold text-neutral-900 dark:text-white cursor-pointer truncate">Account Activity</label>
                                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                        <input id="notif-activity" type="checkbox" class="sr-only peer" checked>
                                        <div class="w-9 h-5 bg-neutral-200 dark:bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-neutral-900 dark:peer-checked:bg-white"></div>
                                    </label>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Get notified about logins, security changes, and project mentions.</p>
                            </div>

                            <!-- Product Updates -->
                            <div class="p-4 sm:p-5 rounded-xl border border-neutral-200 dark:border-neutral-800 flex flex-col justify-start gap-1 transition-colors hover:border-neutral-300 dark:hover:border-neutral-700 h-full bg-transparent">
                                <div class="flex items-center justify-between gap-2">
                                    <label for="notif-marketing" class="text-sm font-semibold text-neutral-900 dark:text-white cursor-pointer truncate">Product Updates</label>
                                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                        <input id="notif-marketing" type="checkbox" class="sr-only peer">
                                        <div class="w-9 h-5 bg-neutral-200 dark:bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-neutral-900 dark:peer-checked:bg-white"></div>
                                    </label>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">News about new features, webinars, and special offers.</p>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4 pt-2">
                        <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3 mb-2">
                            <h3 class="text-xs font-bold tracking-widest text-neutral-500 dark:text-neutral-400 uppercase">
                                Desktop & Mobile
                            </h3>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Push Notifications -->
                            <div class="p-4 sm:p-5 rounded-xl border border-neutral-200 dark:border-neutral-800 flex flex-col justify-start gap-1 transition-colors hover:border-neutral-300 dark:hover:border-neutral-700 h-full bg-transparent">
                                <div class="flex items-center justify-between gap-2">
                                    <div class="flex items-center gap-2 overflow-hidden">
                                        <div class="p-1.5 bg-neutral-50 dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-md shrink-0">
                                            <svg class="w-3.5 h-3.5 text-neutral-500 dark:text-neutral-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                        <label for="notif-push" class="text-sm font-semibold text-neutral-900 dark:text-white cursor-pointer truncate">Push Notifications</label>
                                    </div>
                                    <label class="relative inline-flex items-center cursor-pointer shrink-0">
                                        <input id="notif-push" type="checkbox" class="sr-only peer">
                                        <div class="w-9 h-5 bg-neutral-200 dark:bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-neutral-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-neutral-900 dark:peer-checked:bg-white"></div>
                                    </label>
                                </div>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">Enable real-time desktop or mobile alerts for instant feedback.</p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="px-6 py-4 bg-neutral-50/80 dark:bg-neutral-800/40 border-t border-neutral-200 dark:border-neutral-800 flex items-center justify-between">
                    <p class="text-xs text-neutral-500 dark:text-neutral-400 hidden sm:block">Last updated: Today at 10:24 AM</p>
                    <div class="flex items-center justify-end gap-4 w-full sm:w-auto">
                        <button type="button" class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors">
                            Reset
                        </button>
                        <x-primary-button type="submit" class="w-full sm:w-auto px-6 py-2.5">
                            Save Changes
                        </x-primary-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
