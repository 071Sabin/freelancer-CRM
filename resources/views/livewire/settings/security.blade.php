<div>
    <x-main-heading title="Security Settings" subtitle="Manage your password, 2FA, and active sessions." />

    <div class="mt-6 space-y-6">
        
        <!-- Password Section -->
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
            <form action="#" method="POST">
                <div class="p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                    <div class="lg:col-span-4">
                        <h3 class="text-base font-semibold leading-6 text-neutral-900 dark:text-white">Password</h3>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">
                            Ensure your account is using a long, random password to stay secure.
                        </p>
                    </div>

                    <div class="lg:col-span-8 space-y-5">
                        <div class="max-w-xl">
                            <x-input-field type="password" label="Current Password" name="current_password" placeholder="••••••••" />
                        </div>
                        <div class="max-w-xl">
                            <x-input-field type="password" label="New Password" name="password" placeholder="••••••••" />
                        </div>
                        <div class="max-w-xl">
                            <x-input-field type="password" label="Confirm Password" name="password_confirmation" placeholder="••••••••" />
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-neutral-50/80 dark:bg-neutral-800/40 border-t border-neutral-200 dark:border-neutral-800 flex justify-end">
                    <x-primary-button type="submit">Update Password</x-primary-button>
                </div>
            </form>
        </div>

        <!-- 2FA Section -->
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden p-6 sm:p-8">
            <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-6">
                <div class="flex items-start gap-4">
                    <div class="flex items-center justify-center w-11 h-11 bg-neutral-100 dark:bg-neutral-800 rounded-xl text-neutral-600 dark:text-neutral-300 shrink-0 border border-neutral-200/50 dark:border-neutral-700">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-neutral-900 dark:text-white flex items-center gap-2">
                            Two-Factor Authentication
                            <span class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-neutral-800 px-2.5 py-0.5 text-xs font-medium text-neutral-600 dark:text-neutral-400">Disabled</span>
                        </h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1 max-w-xl">
                            Add an extra layer of security to your account using an authenticator app like Google Authenticator or Authy.
                        </p>
                    </div>
                </div>
                <form action="#" method="POST" class="shrink-0 w-full sm:w-auto mt-2 sm:mt-0">
                    <button type="submit" class="w-full sm:w-auto px-4 py-2 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-900 dark:focus:ring-neutral-300">
                        Enable 2FA
                    </button>
                </form>
            </div>
        </div>

        <!-- Active Sessions Section -->
        <div class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
            <div class="p-6 sm:p-8">
                <h3 class="text-base font-semibold leading-6 text-neutral-900 dark:text-white mb-1">Active Sessions</h3>
                <p class="text-sm text-neutral-500 dark:text-neutral-400 mb-6">Manage and revoke your active sessions across other devices and browsers.</p>
                
                <div class="bg-neutral-50/50 dark:bg-neutral-900/30 rounded-xl border border-neutral-200 dark:border-neutral-800 overflow-hidden">
                    <ul class="divide-y divide-neutral-200 dark:divide-neutral-800">
                        <li class="flex flex-col sm:flex-row sm:items-center justify-between p-4 sm:p-5 gap-4">
                            <div class="flex items-start sm:items-center gap-4">
                                <div class="p-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                    <svg class="w-6 h-6 text-neutral-500 dark:text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-neutral-900 dark:text-white flex items-center gap-2">
                                        Chrome on macOS
                                        <span class="text-[10px] uppercase tracking-wider font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2 py-0.5 rounded-full">This device</span>
                                    </p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        192.168.1.1 &bull; San Francisco, US
                                    </p>
                                </div>
                            </div>
                        </li>

                        <li class="flex flex-col sm:flex-row sm:items-center justify-between p-4 sm:p-5 gap-4 bg-white dark:bg-neutral-900">
                            <div class="flex items-start sm:items-center gap-4">
                                <div class="p-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg">
                                    <svg class="w-6 h-6 text-neutral-500 dark:text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-neutral-900 dark:text-white">Safari on iPhone</p>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-0.5">
                                        Last active 2 days ago
                                    </p>
                                </div>
                            </div>
                            <button class="text-xs font-semibold text-red-600 hover:text-red-700 dark:text-red-400 dark:hover:text-red-300 transition-colors w-full sm:w-auto text-left sm:text-right">
                                Revoke Session
                            </button>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
