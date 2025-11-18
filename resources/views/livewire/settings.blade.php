<!-- settings root -->
<div id="settings-root" class="space-y-6">

    <!-- Header -->
    <header class="flex items-start justify-between">
        <div>
            <x-main-heading title="Settings"
                subtitle="Manage account, security, appearance and integrations"></x-main-heading>
        </div>


        @if (session('success'))
            <x-success-message>
                {{ session('success') }}
            </x-success-message>
        @endif


        <div class="flex items-center gap-3">
            <!-- Theme toggle UI (JS toggles 'dark' on <html>) -->
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600 dark:text-neutral-400">Theme</span>
                <button id="settings-theme-toggle" type="button"
                    class="relative inline-flex items-center h-7 w-14 rounded-full bg-neutral-200 dark:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                    aria-pressed="false">
                    <span id="settings-theme-thumb"
                        class="inline-block h-5 w-5 transform rounded-full bg-white shadow transition translate-x-1 dark:translate-x-7"></span>
                </button>
            </div>

            <a href="#"
                class="inline-flex items-center gap-2 px-3 py-2 rounded-md bg-neutral-100 dark:bg-neutral-700 dark:text-neutral-100 text-sm hover:bg-neutral-200 dark:hover:bg-neutral-600">View
                profile</a>
        </div>
    </header>

    <div class="lg:flex lg:items-start lg:gap-6">

        <!-- Left nav (tabs) -->
        <nav id="settings-nav" aria-label="Settings sections"
            class="mb-4 lg:mb-0 lg:w-72 shrink-0 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-4">
                <img src="{{ $user->avatar_url ?? '/img/default-avatar.png' }}"
                    alt="{{ Auth::guard('freelancers')->user()->name ?? 'User' }}"
                    class="w-10 h-10 rounded-full object-cover border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-700" />
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-neutral-100 title-case">
                        {{ Auth::guard('freelancers')->user()->name ?? 'User Name' }}</p>
                    <p class="text-xs text-gray-500 dark:text-neutral-400">
                        {{ Auth::guard('freelancers')->user()->email ?? 'email@example.com' }}</p>
                </div>
            </div>

            <div class="space-y-1">
                <button data-tab="profile"
                    class="w-full text-left px-3 py-2 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:outline-none"
                    aria-controls="panel-profile">Profile</button>
                <button data-tab="security"
                    class="w-full text-left px-3 py-2 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:outline-none"
                    aria-controls="panel-security">Security</button>
                <button data-tab="notifications"
                    class="w-full text-left px-3 py-2 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:outline-none"
                    aria-controls="panel-notifications">Notifications</button>
                <button data-tab="appearance"
                    class="w-full text-left px-3 py-2 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:outline-none"
                    aria-controls="panel-appearance">Appearance</button>
                <button data-tab="integrations" href="#panel-integrations"
                    class="w-full text-left px-3 py-2 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:outline-none"
                    aria-controls="panel-appearance">Integrations</button>
                <button data-tab="api"
                    class="w-full text-left px-3 py-2 rounded-md hover:bg-neutral-100 dark:hover:bg-neutral-700 focus:outline-none"
                    aria-controls="panel-api">API Keys</button>
                <a data-tab="danger" href="#panel-danger"
                    class="w-full text-left px-3 py-2 rounded-md text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900 focus:outline-none"
                    aria-controls="panel-danger">Danger Zone</a>
            </div>
        </nav>

        <!-- Right content -->
        <section id="settings-panels" class="flex-1 space-y-6">

            <!-- Profile -->
            <section id="panel-profile" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Profile</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Update name, email, bio and avatar.</p>

                <form wire:submit="updateInfo" enctype="multipart/form-data" class="space-y-4">
                    <!-- grid: form fields + avatar -->
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2 space-y-3">
                            <label class="block">
                                <span class="text-sm text-gray-600 dark:text-neutral-400">Full name</span>
                                <x-input-field type="text" model="name" />
                            </label>

                            <label class="block">
                                <span class="text-sm text-gray-600 dark:text-neutral-400">Email</span>
                                <x-input-field type="email" model="email" />
                            </label>

                            <label class="block">
                                <span class="text-sm text-gray-600 dark:text-neutral-400">Bio</span>
                                <textarea wire:model="bio" rows="3"
                                    class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 py-2 px-3 text-gray-800 dark:text-neutral-100 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ Auth::guard('freelancers')->user()->bio ?? '' }}</textarea>
                            </label>
                        </div>

                        <div class="flex flex-col items-center gap-3">
                            <div
                                class="w-28 h-28 rounded-full overflow-hidden border border-neutral-200 dark:border-neutral-700 bg-neutral-50 dark:bg-neutral-700">
                                <img id="settings-avatar-preview"
                                    src="{{ $user->avatar_url ?? '/img/default-avatar.png' }}" alt="Avatar"
                                    class="w-full h-full object-cover" />
                            </div>

                            <label class="block w-full text-sm">
                                <x-file-upload></x-file-upload>
                                <span class="text-xs text-gray-500 dark:text-neutral-400">Change avatar (PNG/JPG, max
                                    2MB)</span>
                            </label>

                            <div class="w-full">
                                <button type="submit"
                                    class="w-full px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save
                                    changes</button>
                            </div>
                        </div>
                    </div>
                </form>
            </section>

            <!-- Security -->
            <section id="panel-security" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Security</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Change password, enable 2FA, and manage
                    active sessions.</p>

                <!-- Change password -->
                <form action="#" method="POST" class="space-y-3 mb-6">
                    <label>
                        <span class="text-sm text-gray-600 dark:text-neutral-400">Current password</span>
                        <input name="current_password" type="password"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 py-2 px-3 text-gray-800 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </label>

                    <label>
                        <span class="text-sm text-gray-600 dark:text-neutral-400">New password</span>
                        <input name="password" type="password"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 py-2 px-3 text-gray-800 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </label>

                    <label>
                        <span class="text-sm text-gray-600 dark:text-neutral-400">Confirm new password</span>
                        <input name="password_confirmation" type="password"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 py-2 px-3 text-gray-800 dark:text-neutral-100 focus:outline-none focus:ring-2 focus:ring-indigo-500" />
                    </label>

                    <div>
                        <button type="submit"
                            class="px-4 py-2 mt-3 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Update
                            password</button>
                    </div>
                </form>

                <!-- 2FA toggle -->
                <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-800 dark:text-neutral-100">Two-factor
                                Authentication</h3>
                            <p class="text-sm text-gray-500 dark:text-neutral-400">Use an authenticator app for
                                stronger account security.</p>
                        </div>
                        <form action="#" method="POST">
                            <button type="submit"
                                class="px-3 py-2 rounded-md bg-neutral-100 dark:bg-neutral-700 dark:text-neutral-100">Enable
                                / Disable</button>
                        </form>
                    </div>
                </div>

                <!-- Sessions -->
                <div class="border-t border-neutral-200 dark:border-neutral-700 pt-4 mt-4">
                    <h3 class="text-sm font-medium text-gray-800 dark:text-neutral-100">Active sessions</h3>
                    <p class="text-sm text-gray-500 dark:text-neutral-400 mb-3">Revoke sessions you don't recognize.
                    </p>

                    <ul class="space-y-2">
                        <!-- Example session item -->
                        <li
                            class="flex items-center justify-between p-2 rounded-md bg-neutral-50 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-700">
                            <div>
                                <p class="text-sm font-medium text-gray-800 dark:text-neutral-100">Chrome • Mac</p>
                                <p class="text-xs text-gray-500 dark:text-neutral-400">IP 192.0.2.1 • 2 hours ago</p>
                            </div>
                            <button class="text-xs text-rose-600">Sign out</button>
                        </li>
                    </ul>
                </div>
            </section>

            <!-- Notifications -->
            <section id="panel-notifications" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Notifications</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Control how you receive updates.</p>

                <form action="#" method="POST" class="space-y-4">
                    <fieldset class="space-y-3">
                        <legend class="text-sm font-medium text-gray-700 dark:text-neutral-200">Email notifications
                        </legend>

                        <label class="flex items-center gap-3">
                            <input id="notif-activity" name="notif_activity" type="checkbox"
                                class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-indigo-600" />
                            <span class="text-sm text-gray-600 dark:text-neutral-400">Activity emails</span>
                        </label>

                        <label class="flex items-center gap-3">
                            <input id="notif-marketing" name="notif_marketing" type="checkbox"
                                class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-indigo-600" />
                            <span class="text-sm text-gray-600 dark:text-neutral-400">Marketing & product
                                updates</span>
                        </label>
                    </fieldset>

                    <fieldset class="space-y-3">
                        <legend class="text-sm font-medium text-gray-700 dark:text-neutral-200">Push notifications
                        </legend>
                        <p class="text-xs text-gray-500 dark:text-neutral-400">Enable push to receive real-time alerts.
                        </p>

                        <label class="flex items-center gap-3">
                            <input id="notif-push" name="notif_push" type="checkbox"
                                class="h-4 w-4 rounded border-neutral-300 dark:border-neutral-600 text-indigo-600" />
                            <span class="text-sm text-gray-600 dark:text-neutral-400">Enable push notifications</span>
                        </label>
                    </fieldset>

                    <div>
                        <button type="submit"
                            class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save
                            preferences</button>
                    </div>
                </form>
            </section>

            <!-- Appearance -->
            <section id="panel-appearance" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Appearance</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Customize the theme and layout.</p>

                <form action="#" method="POST" class="space-y-4">
                    <fieldset>
                        <legend class="text-sm font-medium text-gray-700 dark:text-neutral-200 mb-2">Theme</legend>
                        <div class="flex gap-3 items-center">
                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="theme" value="system" class="form-radio" checked>
                                <span class="text-sm text-gray-600 dark:text-neutral-400">System</span>
                            </label>

                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="theme" value="light" class="form-radio">
                                <span class="text-sm text-gray-600 dark:text-neutral-400">Light</span>
                            </label>

                            <label class="inline-flex items-center gap-2">
                                <input type="radio" name="theme" value="dark" class="form-radio">
                                <span class="text-sm text-gray-600 dark:text-neutral-400">Dark</span>
                            </label>
                        </div>
                    </fieldset>

                    {{-- <fieldset>
                        <legend class="text-sm font-medium text-gray-700 dark:text-neutral-200 mb-2">Layout</legend>
                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="compact" class="form-checkbox">
                            <span class="text-sm text-gray-600 dark:text-neutral-400">Compact sidebar</span>
                        </label>

                        <label class="inline-flex items-center gap-2">
                            <input type="checkbox" name="condensed" class="form-checkbox">
                            <span class="text-sm text-gray-600 dark:text-neutral-400">Condensed header</span>
                        </label>
                    </fieldset> --}}

                    <div>
                        <button class="px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700">Save
                            appearance settings</button>
                    </div>
                </form>
            </section>

            <!-- Integrations -->
            <section id="panel-integrations" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Integrations</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Connect apps and services.</p>

                <div class="grid md:grid-cols-2 gap-4">
                    <div
                        class="p-4 rounded-md bg-neutral-50 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-sm font-medium text-gray-800 dark:text-neutral-100">Slack</h3>
                        <p class="text-sm text-gray-500 dark:text-neutral-400">Send notifications to a Slack channel.
                        </p>
                        <div class="mt-3 flex gap-3">
                            <a href="#" class="px-3 py-2 rounded-md bg-indigo-600 text-white">Connect</a>
                            <a href="#" class="text-sm text-gray-500 dark:text-neutral-400">Settings</a>
                        </div>
                    </div>

                    <div
                        class="p-4 rounded-md bg-neutral-50 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-700">
                        <h3 class="text-sm font-medium text-gray-800 dark:text-neutral-100">Google</h3>
                        <p class="text-sm text-gray-500 dark:text-neutral-400">Import calendars and contacts.</p>
                        <div class="mt-3 flex gap-3">
                            <a href="#" class="px-3 py-2 rounded-md bg-indigo-600 text-white">Connect</a>
                            <a href="#" class="text-sm text-gray-500 dark:text-neutral-400">Settings</a>
                        </div>
                    </div>
                </div>
            </section>


            <!-- API Keys -->
            <section id="panel-api" role="tabpanel"
                class="tab-panel hidden bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">API Keys</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Create and manage API keys.</p>

                <form id="settings-create-key" action="#" method="POST" class="mb-4">
                    <label class="block">
                        <span class="text-sm text-gray-600 dark:text-neutral-400">Key name</span>
                        <input name="name"
                            class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 py-2 px-3 text-gray-800 dark:text-neutral-100" />
                    </label>
                    <div class="mt-3 flex items-center gap-3">
                        <button type="submit" class="px-3 py-2 rounded-md bg-indigo-600 text-white">Create
                            key</button>
                        <span class="text-xs text-gray-500 dark:text-neutral-400">Save the key now: it will not be
                            shown again.</span>
                    </div>
                </form>

                <div class="space-y-2">
                    <!-- Example key item -->
                    <div
                        class="flex items-center justify-between p-3 rounded-md bg-neutral-50 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-700">
                        <div>
                            <p class="text-sm font-medium text-gray-800 dark:text-neutral-100">Default Key</p>
                            <p class="text-xs text-gray-500 dark:text-neutral-400">Created 2 days ago</p>
                        </div>
                        <div class="flex items-center gap-2">
                            <button data-copy="plain-api-key-string"
                                class="px-2 py-1 text-xs rounded-md bg-neutral-100 dark:bg-neutral-600">Copy</button>
                            <button class="px-2 py-1 text-xs text-rose-600">Revoke</button>
                        </div>
                    </div>
                </div>
            </section>

            <!-- Danger -->
            <section id="panel-danger" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Danger Zone</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Irreversible actions — proceed carefully.
                </p>

                <div class="space-y-4">
                    <div
                        class="p-4 rounded-md bg-neutral-50 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-700">
                        <h3 class="font-medium text-gray-800 dark:text-neutral-100">Delete account</h3>
                        <p class="text-sm text-gray-500 dark:text-neutral-400">This permanently deletes your account
                            and all data.</p>
                        <button data-modal-open="delete-account"
                            class="mt-3 px-3 py-2 rounded-md bg-rose-600 text-white">Delete account</button>
                    </div>

                    <div
                        class="p-4 rounded-md bg-neutral-50 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-700">
                        <h3 class="font-medium text-gray-800 dark:text-neutral-100">Export data</h3>
                        <p class="text-sm text-gray-500 dark:text-neutral-400">Request a download of your data (GDPR).
                        </p>
                        <form action="#" method="POST">
                            <button class="mt-3 px-3 py-2 rounded-md bg-neutral-100 dark:bg-neutral-600">Request
                                export</button>
                        </form>
                    </div>
                </div>
            </section>

        </section>
    </div>

    <!-- Modal markup placeholder (hidden by default) -->
    <div id="modal-delete-account" class="fixed inset-0 hidden items-center justify-center z-50">
        <div class="absolute inset-0 bg-black/40"></div>
        <div class="relative max-w-lg w-full bg-white dark:bg-neutral-800 rounded-xl p-6 z-10">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Confirm account deletion</h3>
            <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Type <span
                    class="font-mono bg-neutral-100 dark:bg-neutral-700 px-2 py-1 rounded">DELETE</span> to confirm.
            </p>
            <form id="modal-delete-account-form" action="#" method="POST">
                <label class="block">
                    <input id="modal-delete-input" name="confirm"
                        class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 py-2 px-3 text-gray-800 dark:text-neutral-100"
                        placeholder="Type DELETE" />
                </label>
                <div class="mt-4 flex gap-3">
                    <button type="button" data-modal-close="delete-account"
                        class="px-3 py-2 rounded-md bg-neutral-100 dark:bg-neutral-700">Cancel</button>
                    <button type="submit" id="modal-delete-confirm" disabled
                        class="px-3 py-2 rounded-md bg-rose-600 text-white disabled:opacity-50">Delete account</button>
                </div>
            </form>
        </div>
    </div>

</div>
