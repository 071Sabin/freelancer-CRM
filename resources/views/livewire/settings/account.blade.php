<div>
    <x-main-heading title="Account Settings" subtitle="Manage data export and account deletion." />

    <div class="mt-6 space-y-6">
        
        <!-- Data Management Card -->
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden relative">
            <div class="p-6 sm:p-8 space-y-8">
                
                <div class="space-y-4">
                    <div class="flex items-center justify-between border-b border-neutral-200 dark:border-neutral-800 pb-3 mb-2">
                        <h3 class="text-xs font-bold tracking-widest text-neutral-500 dark:text-neutral-400 uppercase">
                            Data Management
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Export Data -->
                        <div class="p-4 sm:p-5 bg-neutral-50/50 dark:bg-neutral-800/30 rounded-xl border border-neutral-200 dark:border-neutral-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors hover:border-neutral-300 dark:hover:border-neutral-700">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-700 rounded-lg shrink-0 shadow-sm flex items-center justify-center">
                                    <svg class="w-5 h-5 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12" />
                                    </svg>
                                </div>
                                <div class="space-y-0.5">
                                    <h4 class="text-sm font-semibold text-neutral-900 dark:text-white">Export Data</h4>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 max-w-lg">
                                        Download a copy of your personal data, including projects and invoices, in JSON format (GDPR Compliant).
                                    </p>
                                </div>
                            </div>
                            <form action="#" method="POST" class="flex-shrink-0 w-full sm:w-auto mt-2 sm:mt-0">
                                <button type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg shadow-sm text-sm font-semibold text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-200 transition-colors">
                                    Export Data
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="space-y-4 pt-2">
                    <div class="flex items-center justify-between border-b border-red-200/50 dark:border-red-900/30 pb-3 mb-2">
                        <h3 class="text-xs font-bold tracking-widest text-red-500 dark:text-red-400 uppercase">
                            Danger Zone
                        </h3>
                    </div>

                    <div class="space-y-4">
                        <!-- Delete Account -->
                        <div class="p-4 sm:p-5 rounded-xl border border-red-200 dark:border-red-900/50 bg-red-50/50 dark:bg-red-900/10 flex flex-col sm:flex-row sm:items-center justify-between gap-4 transition-colors hover:border-red-300 dark:hover:border-red-800/60">
                            <div class="flex items-center gap-4">
                                <div class="p-2 bg-white dark:bg-neutral-900 border border-red-200 dark:border-red-800/50 rounded-lg shrink-0 shadow-sm flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </div>
                                <div class="space-y-0.5">
                                    <h4 class="text-sm font-semibold text-red-700 dark:text-red-400">Delete Account</h4>
                                    <p class="text-xs text-red-600/80 dark:text-red-300/70 max-w-xl">
                                        This action is permanent and cannot be undone. All your projects, client data, and invoices will be permanently erased.
                                    </p>
                                </div>
                            </div>
                            <div class="flex-shrink-0 w-full sm:w-auto mt-2 sm:mt-0">
                                <flux:modal.trigger name="delete-account-modal">
                                    <button type="button" class="w-full sm:w-auto inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-semibold rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition-colors">
                                        Delete Account
                                    </button>
                                </flux:modal.trigger>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Delete Account Modal -->
    <flux:modal name="delete-account-modal" class="max-w-lg">
        <form wire:submit.prevent="deleteAccount">
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-bold text-neutral-900 dark:text-white">Delete Account</h3>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-2">
                        Are you sure you want to delete your account? This action is permanent and cannot be undone. All your projects, client data, and invoices will be permanently erased.
                    </p>
                </div>

                <div class="space-y-3">
                    <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300">
                        To verify, type <strong class="text-neutral-900 dark:text-white">{{ $userEmail }}</strong> below:
                    </label>
                    <x-input-field type="text" model="confirmEmail" placeholder="Enter your email" required="true" />
                </div>
                
                <div class="flex items-center justify-end gap-3 pt-2">
                    <flux:modal.close>
                        <button type="button" class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                            Cancel
                        </button>
                    </flux:modal.close>
                    <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-600 transition-colors">
                        Yes, delete my account
                    </button>
                </div>
            </div>
        </form>
    </flux:modal>
</div>
