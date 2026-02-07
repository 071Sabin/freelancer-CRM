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

        <x-error></x-error>
    </header>

    <div class="lg:flex lg:items-start lg:gap-6">

        <!-- Left nav (tabs) -->
        <nav id="settings-nav" aria-label="Settings sections"
            class="mb-4 lg:mb-0 lg:w-72 shrink-0 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-4">
            <div class="flex items-center gap-3 mb-4">
                <flux:profile :chevron="false" circle
                    :avatar="Auth::guard('web')->user()->profile_pic ? asset('uploads/' . Auth::guard('web')->user()->profile_pic) : null" />
                <div>
                    <p class="text-sm font-semibold text-gray-800 dark:text-neutral-100">
                        {{ Auth::guard('web')->user()->name ?? 'User Name' }}</p>
                    <p class="text-xs text-gray-500 dark:text-neutral-400">
                        {{ Auth::guard('web')->user()->email ?? 'email@example.com' }}</p>
                </div>
            </div>

            <nav class="space-y-1 w-full" aria-label="Settings Sidebar">

                <div
                    class="px-3 mb-2 mt-4 md:mt-0 text-[11px] font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider">
                    General
                </div>

                <button data-tab="profile" aria-controls="panel-profile"
                    class="group w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg transition-all duration-200
               bg-neutral-100 dark:bg-neutral-800 text-neutral-900 dark:text-white">
                    <svg class="w-4 h-4 text-neutral-500 dark:text-neutral-400 group-hover:text-neutral-900 dark:group-hover:text-white transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Profile
                </button>

                <button data-tab="security" aria-controls="panel-security"
                    class="group w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 hover:text-neutral-900 dark:hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-neutral-200 dark:focus:ring-neutral-700">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-600 dark:group-hover:text-neutral-300 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Security
                </button>

                <button data-tab="notifications" aria-controls="panel-notifications"
                    class="group w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 hover:text-neutral-900 dark:hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-neutral-200 dark:focus:ring-neutral-700">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-600 dark:group-hover:text-neutral-300 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    Notifications
                </button>

                <button data-tab="appearance" aria-controls="panel-appearance"
                    class="group w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 hover:text-neutral-900 dark:hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-neutral-200 dark:focus:ring-neutral-700">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-600 dark:group-hover:text-neutral-300 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01" />
                    </svg>
                    Appearance
                </button>

                <div
                    class="px-3 mt-6 mb-2 text-[11px] font-bold text-neutral-400 dark:text-neutral-500 uppercase tracking-wider">
                    Workspace
                </div>

                <button data-tab="integrations" aria-controls="panel-integrations"
                    class="group w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 hover:text-neutral-900 dark:hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-neutral-200 dark:focus:ring-neutral-700">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-600 dark:group-hover:text-neutral-300 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z" />
                    </svg>
                    Integrations
                </button>

                <button data-tab="api" aria-controls="panel-api"
                    class="group w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-neutral-600 dark:text-neutral-400 hover:bg-neutral-50 dark:hover:bg-neutral-800/50 hover:text-neutral-900 dark:hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-neutral-200 dark:focus:ring-neutral-700">
                    <svg class="w-4 h-4 text-neutral-400 group-hover:text-neutral-600 dark:group-hover:text-neutral-300 transition-colors"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                    </svg>
                    API Keys
                </button>

                <div class="my-4 border-t border-neutral-100 dark:border-neutral-800"></div>

                <a data-tab="danger" href="#panel-danger" aria-controls="panel-danger"
                    class="group w-full flex items-center gap-3 px-3 py-2 text-sm font-medium rounded-lg text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20 hover:text-red-700 dark:hover:text-red-400 transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-red-500/20">
                    <svg class="w-4 h-4 text-red-500/70 group-hover:text-red-600 dark:text-red-400 dark:group-hover:text-red-300"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Danger Zone
                </a>
            </nav>
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
                                <x-input-field type="text" model="name" label="Full Name" required />
                            </label>

                            <label class="block">
                                <x-input-field type="email" model="email" readonly
                                    class="text-stone-400 dark:text-neutral-600" label="Email" />
                            </label>

                            <label class="block">
                                <div class="flex justify-between">
                                    <p class="text-sm text-gray-600 dark:text-neutral-400 font-semibold">Bio</p>
                                    <p class="text-xs text-neutral-500">Optional</p>
                                </div>

                                <textarea wire:model="bio" rows="3"
                                    class="mt-1 block w-full rounded-md border border-neutral-200 dark:border-neutral-700 bg-white dark:bg-neutral-900 py-2 px-3 text-gray-800 dark:text-neutral-100 focus:outline-none focus:ring-1 focus:ring-blue-500">{{ Auth::guard('web')->user()->bio ?? '' }}</textarea>
                            </label>
                        </div>

                        <div
                            class="bg-neutral-50/50 dark:bg-neutral-900/50 rounded-xl border border-neutral-100 dark:border-neutral-800 p-6 flex flex-col items-center text-center">

                            <div class="relative mb-4 group">
                                <div
                                    class="w-28 h-28 rounded-full ring-4 ring-white dark:ring-neutral-800 shadow-lg overflow-hidden bg-neutral-200 dark:bg-neutral-700 relative">

                                    <div wire:loading wire:target="profile_pic"
                                        class="absolute inset-0 bg-black/20 backdrop-blur-sm z-50 flex items-center justify-center">
                                        <svg class="animate-spin h-8 w-8 text-white"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>

                                    @if ($profile_pic)
                                        <img src="{{ $profile_pic->temporaryUrl() }}"
                                            class="w-full h-full object-cover animate-fade-in">
                                    @elseif(Auth::guard('web')->user()->profile_pic)
                                        <img src="{{ asset('uploads/' . Auth::guard('web')->user()->profile_pic) }}"
                                            class="w-full h-full object-cover">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-400 dark:text-neutral-500">
                                            <svg class="h-12 w-12" fill="currentColor" viewBox="0 0 24 24">
                                                <path
                                                    d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <span
                                    class="absolute bottom-1 right-1 h-5 w-5 rounded-full border-[3px] border-white dark:border-neutral-900 bg-green-500"></span>
                            </div>

                            <div class="w-full">
                                <label for="profile_upload"
                                    class="cursor-pointer inline-flex items-center justify-center w-full px-4 py-2 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm text-sm font-medium text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all active:scale-95">
                                    <svg class="w-4 h-4 mr-2 text-neutral-500 dark:text-neutral-400" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                    </svg>
                                    Upload New Photo
                                </label>

                                <input type="file" id="profile_upload" wire:model="profile_pic" class="hidden"
                                    accept="image/png, image/jpeg">
                            </div>

                            <div class="mt-4 space-y-1">
                                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                    Recommended: 400x400px
                                </p>
                                <p class="text-[10px] uppercase tracking-wide text-neutral-400 dark:text-neutral-500">
                                    JPG or PNG, Max 2MB
                                </p>
                                @error('profile_pic')
                                    <p
                                        class="text-xs text-red-500 mt-2 font-medium bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <x-primary-button type="submit" wire:loading.attr="disabled">
                        <svg wire:loading wire:target="updateInfo"
                            class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                        update profile
                    </x-primary-button>
                </form>
            </section>

            <!-- Security -->
            <section id="panel-security" role="tabpanel"
                class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700/60 rounded-xl shadow-sm overflow-hidden">

                <div
                    class="px-6 py-5 border-b border-neutral-100 dark:border-neutral-700/60 bg-neutral-50/50 dark:bg-neutral-800">
                    <h2 class="text-base font-semibold text-neutral-900 dark:text-white">Security Settings</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Manage your password, 2FA, and active
                        sessions.</p>
                </div>

                <div class="p-6 space-y-8">

                    <form action="#" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1">
                                <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Password</h3>
                                <p class="text-xs text-neutral-500 dark:text-neutral-400 mt-1 leading-relaxed">
                                    Ensure your account is using a long, random password to stay secure.
                                </p>
                            </div>

                            <div class="md:col-span-2 space-y-4">
                                <x-input-field type="password" label="Current Password" name="current_password" />

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <x-input-field type="password" label="New Password" name="password" />
                                    <x-input-field type="password" label="Confirm Password"
                                        name="password_confirmation" />
                                </div>

                                <div class="pt-2 flex justify-end">
                                    <x-primary-button type="submit">Update Password</x-primary-button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="border-t border-neutral-100 dark:border-neutral-700/60"></div>

                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        <div class="flex items-start gap-4">
                            <div
                                class="p-2 bg-neutral-100 dark:bg-neutral-700/50 rounded-lg text-neutral-500 dark:text-neutral-400">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3
                                    class="text-sm font-medium text-neutral-900 dark:text-white flex items-center gap-2">
                                    Two-Factor Authentication
                                    <span
                                        class="inline-flex items-center rounded-md bg-neutral-100 dark:bg-neutral-700/50 px-2 py-1 text-xs font-medium text-neutral-600 dark:text-neutral-400">Disabled</span>
                                </h3>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1 max-w-md">
                                    Add an extra layer of security to your account using an authenticator app like
                                    Google Authenticator or Authy.
                                </p>
                            </div>
                        </div>
                        <form action="#" method="POST">
                            <button type="submit"
                                class="whitespace-nowrap px-4 py-2 border border-neutral-300 dark:border-neutral-600 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Enable 2FA
                            </button>
                        </form>
                    </div>

                    <div class="border-t border-neutral-100 dark:border-neutral-700/60"></div>

                    <div>
                        <h3 class="text-sm font-medium text-neutral-900 dark:text-white mb-4">Active Sessions</h3>
                        <div
                            class="bg-neutral-50 dark:bg-neutral-900/50 rounded-xl border border-neutral-200 dark:border-neutral-700/60 overflow-hidden">
                            <ul class="divide-y divide-neutral-200 dark:divide-neutral-700/60">

                                <li class="flex items-center justify-between p-4">
                                    <div class="flex items-center gap-4">
                                        <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p
                                                class="text-sm font-medium text-neutral-900 dark:text-white flex items-center gap-2">
                                                Chrome on macOS
                                                <span
                                                    class="text-xs text-green-600 dark:text-green-400 bg-green-50 dark:bg-green-500/10 px-1.5 py-0.5 rounded font-medium">This
                                                    device</span>
                                            </p>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                                192.168.1.1 • San Francisco, US
                                            </p>
                                        </div>
                                    </div>
                                </li>

                                <li class="flex items-center justify-between p-4 bg-white dark:bg-neutral-800">
                                    <div class="flex items-center gap-4">
                                        <svg class="w-8 h-8 text-neutral-400" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-sm font-medium text-neutral-900 dark:text-white">Safari on
                                                iPhone</p>
                                            <p class="text-xs text-neutral-500 dark:text-neutral-400">
                                                Last active 2 days ago
                                            </p>
                                        </div>
                                    </div>
                                    <button
                                        class="text-xs font-medium text-red-600 hover:text-red-700 dark:hover:text-red-400 transition-colors">
                                        Revoke
                                    </button>
                                </li>

                            </ul>
                        </div>
                    </div>

                </div>
            </section>

            <!-- Notifications -->
            <section id="panel-notifications" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-2xl overflow-hidden shadow-sm transition-all">

                <div class="p-6 border-b border-neutral-100 dark:border-neutral-700/50">
                    <div class="flex items-center gap-3 mb-1">
                        <div class="p-2 bg-indigo-50 dark:bg-indigo-500/10 rounded-lg">
                            <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-neutral-800 dark:text-neutral-100 tracking-tight">
                            Notification Center</h2>
                    </div>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400 ml-11">Manage your frequency and preferred
                        channels for updates.</p>
                </div>

                <form action="#" method="POST">
                    <div class="p-6 space-y-8">

                        <div class="space-y-4">
                            <div
                                class="flex items-center justify-between border-b border-neutral-50 dark:border-neutral-700/30 pb-2">
                                <h3
                                    class="text-sm font-semibold uppercase tracking-wider text-neutral-400 dark:text-neutral-500">
                                    Email Channels</h3>
                                <span
                                    class="text-[10px] px-2 py-0.5 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 dark:text-emerald-400 font-bold rounded-full">ACTIVE</span>
                            </div>

                            <div class="flex items-start justify-between group">
                                <div class="space-y-0.5">
                                    <label for="notif-activity"
                                        class="text-sm font-medium text-neutral-700 dark:text-neutral-200 cursor-pointer">Account
                                        Activity</label>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-500">Get notified about
                                        logins, security changes, and project mentions.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="notif-activity" type="checkbox" class="sr-only peer" checked>
                                    <div
                                        class="w-10 h-5 bg-neutral-200 dark:bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                            </div>

                            <div class="flex items-start justify-between group">
                                <div class="space-y-0.5">
                                    <label for="notif-marketing"
                                        class="text-sm font-medium text-neutral-700 dark:text-neutral-200 cursor-pointer">Product
                                        Updates</label>
                                    <p class="text-xs text-neutral-500 dark:text-neutral-500">News about new features,
                                        webinars, and special offers.</p>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="notif-marketing" type="checkbox" class="sr-only peer">
                                    <div
                                        class="w-10 h-5 bg-neutral-200 dark:bg-neutral-700 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                        <div
                            class="p-4 bg-neutral-50 dark:bg-neutral-900/50 rounded-xl border border-neutral-100 dark:border-neutral-700/50 space-y-4">
                            <div class="flex items-start justify-between">
                                <div class="flex gap-3">
                                    <div class="mt-1">
                                        <svg class="w-5 h-5 text-neutral-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="space-y-1">
                                        <h3 class="text-sm font-semibold text-neutral-700 dark:text-neutral-200">Push
                                            Notifications</h3>
                                        <p class="text-xs text-neutral-500 dark:text-neutral-400">Enable real-time
                                            desktop or mobile alerts for instant feedback.</p>
                                    </div>
                                </div>
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input id="notif-push" type="checkbox" class="sr-only peer">
                                    <div
                                        class="w-10 h-5 bg-neutral-200 dark:bg-neutral-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-indigo-600">
                                    </div>
                                </label>
                            </div>
                        </div>

                    </div>

                    <div
                        class="px-6 py-4 bg-neutral-50 dark:bg-neutral-800/50 border-t border-neutral-100 dark:border-neutral-700 flex items-center justify-between">
                        <p class="text-xs text-neutral-400">Last updated: Today at 10:24 AM</p>
                        <div class="flex gap-3">
                            <button type="button"
                                class="px-4 py-2 text-sm font-medium text-neutral-600 dark:text-neutral-400 hover:text-neutral-800 dark:hover:text-white transition-colors">
                                Reset
                            </button>
                            <button type="submit"
                                class="px-5 py-2 rounded-xl bg-indigo-600 text-white text-sm font-bold shadow-lg shadow-indigo-500/25 hover:bg-indigo-700 hover:shadow-indigo-500/40 active:scale-95 transition-all duration-200">
                                Save Changes
                            </button>
                        </div>
                    </div>
                </form>
            </section>

            <!-- Appearance -->
            <section id="panel-appearance" role="tabpanel"
                class="tab-panel bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm">
                <h2 class="text-lg font-semibold text-gray-800 dark:text-neutral-100">Appearance</h2>
                <p class="text-sm text-gray-500 dark:text-neutral-400 mb-4">Customize the theme and layout.</p>

                <div x-data="themeSwitcher()" x-init="initTheme()" class="space-y-4">

                    <label class="text-sm font-semibold text-neutral-900 dark:text-neutral-100">
                        Interface Theme
                    </label>

                    <div class="grid grid-cols-3 gap-4">

                        <button @click="setTheme('light')"
                            :class="theme === 'light'
                                ?
                                'ring-2 ring-indigo-600 bg-neutral-50 dark:bg-neutral-800' :
                                'border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800'"
                            class="relative flex flex-col items-center justify-center p-4 rounded-xl transition-all duration-200 outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="radio" aria-label="Light Theme">
                            <div
                                class="w-8 h-8 rounded-full bg-white border border-neutral-200 flex items-center justify-center shadow-sm mb-3 text-amber-500">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-neutral-900 dark:text-neutral-200">Light</span>
                            <div x-show="theme === 'light'" class="absolute top-2 right-2 text-indigo-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <button @click="setTheme('dark')"
                            :class="theme === 'dark'
                                ?
                                'ring-2 ring-indigo-600 bg-neutral-50 dark:bg-neutral-800' :
                                'border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800'"
                            class="relative flex flex-col items-center justify-center p-4 rounded-xl transition-all duration-200 outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="radio" aria-label="Dark Theme">
                            <div
                                class="w-8 h-8 rounded-full bg-neutral-800 border border-neutral-700 flex items-center justify-center shadow-sm mb-3 text-indigo-400">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-neutral-900 dark:text-neutral-200">Dark</span>
                            <div x-show="theme === 'dark'" class="absolute top-2 right-2 text-indigo-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                        <button @click="setTheme('system')"
                            :class="theme === 'system'
                                ?
                                'ring-2 ring-indigo-600 bg-neutral-50 dark:bg-neutral-800' :
                                'border border-neutral-200 dark:border-neutral-800 hover:bg-neutral-50 dark:hover:bg-neutral-800'"
                            class="relative flex flex-col items-center justify-center p-4 rounded-xl transition-all duration-200 outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                            role="radio" aria-label="System Theme">
                            <div
                                class="w-8 h-8 rounded-full bg-neutral-100 dark:bg-neutral-700 border border-neutral-200 dark:border-neutral-600 flex items-center justify-center shadow-sm mb-3 text-neutral-500 dark:text-neutral-300">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <span class="text-sm font-medium text-neutral-900 dark:text-neutral-200">System</span>
                            <div x-show="theme === 'system'" class="absolute top-2 right-2 text-indigo-600">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>

                    </div>
                </div>
            </section>

            <!-- Integrations -->
            <div class="space-y-8">

                <div
                    class="flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-neutral-200 dark:border-neutral-800 pb-6">
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-neutral-900 dark:text-white">Connected Apps
                        </h2>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Supercharge your workflow by
                            connecting your favorite tools.</p>
                    </div>
                    <button
                        class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-900 dark:bg-white text-white dark:text-neutral-900 text-sm font-semibold rounded-lg shadow-sm hover:opacity-90 transition-all active:scale-95">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                        Request Integration
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div
                        class="col-span-1 md:col-span-2 relative overflow-hidden bg-white dark:bg-neutral-800 border border-emerald-500/20 dark:border-emerald-500/30 rounded-xl shadow-sm hover:shadow-md transition-shadow group">

                        <div
                            class="absolute top-0 right-0 -mt-12 -mr-12 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl opacity-0 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none">
                        </div>

                        <div
                            class="p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-6 relative z-10">
                            <div
                                class="flex-shrink-0 w-16 h-16 bg-emerald-50 dark:bg-emerald-900/10 rounded-2xl flex items-center justify-center border border-emerald-100 dark:border-emerald-500/20 shadow-sm">
                                <svg class="w-8 h-8 text-emerald-600 dark:text-emerald-500" fill="currentColor"
                                    viewBox="0 0 24 24">
                                    <path
                                        d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z" />
                                </svg>
                            </div>

                            <div class="flex-1">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-base font-bold text-neutral-900 dark:text-white">WhatsApp Business
                                        API</h3>
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2 py-0.5 rounded-full text-[10px] font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-500/10 dark:text-emerald-400 border border-emerald-100 dark:border-emerald-500/20">
                                        <span class="relative flex h-1.5 w-1.5">
                                            <span
                                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                                            <span
                                                class="relative inline-flex rounded-full h-1.5 w-1.5 bg-emerald-500"></span>
                                        </span>
                                        Connected
                                    </span>
                                </div>
                                <p class="text-sm text-neutral-500 dark:text-neutral-400 leading-relaxed max-w-xl">
                                    Send invoices, receive updates, and chat with clients directly from your dashboard.
                                </p>
                            </div>

                            <div class="flex flex-col items-end gap-3">
                                <button role="switch" aria-checked="true"
                                    class="group relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent bg-emerald-500 transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                                    <span aria-hidden="true"
                                        class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                                </button>
                                <a href="#"
                                    class="text-xs font-medium text-neutral-400 hover:text-neutral-900 dark:hover:text-white transition-colors underline decoration-neutral-300 dark:decoration-neutral-600 underline-offset-2">
                                    Configure
                                </a>
                            </div>
                        </div>

                        <div
                            class="px-6 py-2.5 bg-neutral-50 dark:bg-neutral-900/30 border-t border-neutral-100 dark:border-neutral-700/30 flex justify-between items-center text-xs text-neutral-500 dark:text-neutral-400">
                            <span>Sync Frequency: <strong
                                    class="text-neutral-700 dark:text-neutral-300">Real-time</strong></span>
                            <span>Last synced: 2 mins ago</span>
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm hover:border-neutral-300 dark:hover:border-neutral-600 transition-all duration-200">
                        <div class="flex justify-between items-start mb-5">
                            <div
                                class="w-12 h-12 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center text-indigo-600 dark:text-indigo-400 ring-1 ring-inset ring-indigo-100 dark:ring-indigo-500/20">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M13.976 9.15c-2.172-.806-3.356-1.426-3.356-2.928 0-1.129.85-1.946 2.282-1.946 2.132 0 3.211 1.282 3.396 2.891h4.701C20.833 2.946 18.01 0 12.965 0 7.828 0 4.385 3.284 4.385 7.85c0 4.67 4.163 6.134 7.57 7.23 2.298.8 3.016 1.77 3.016 3.125 0 1.293-1.042 2.215-2.715 2.215-2.583 0-3.95-1.745-4.17-3.666H3.344c.264 4.692 3.737 7.246 8.527 7.246 5.564 0 9.17-3.411 9.17-8.086 0-5.118-4.701-6.666-7.065-7.764z" />
                                </svg>
                            </div>
                            <button role="switch" aria-checked="true"
                                class="bg-indigo-600 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                <span aria-hidden="true"
                                    class="translate-x-5 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>

                        <h3 class="text-base font-bold text-neutral-900 dark:text-white">Stripe Payments</h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-2 mb-4 line-clamp-2">
                            Accept credit cards and manage subscriptions automatically.
                        </p>

                        <div
                            class="flex items-center gap-2 text-xs font-medium text-emerald-600 dark:text-emerald-400 bg-emerald-50 dark:bg-emerald-500/10 px-2.5 py-1 rounded-md w-fit">
                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Active
                        </div>
                    </div>

                    <div
                        class="bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-xl p-6 shadow-sm hover:border-neutral-300 dark:hover:border-neutral-600 transition-all duration-200">
                        <div class="flex justify-between items-start mb-5">
                            <div
                                class="w-12 h-12 bg-neutral-100 dark:bg-neutral-700 rounded-lg flex items-center justify-center text-neutral-600 dark:text-neutral-300 ring-1 ring-inset ring-neutral-200 dark:ring-neutral-600">
                                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="currentColor">
                                    <path
                                        d="M5.042 15.165a2.528 2.528 0 0 1-2.52 2.523A2.528 2.528 0 0 1 0 15.165a2.527 2.527 0 0 1 2.522-2.52h2.52v2.52zM6.313 15.165a2.527 2.527 0 0 1 2.521-2.52 2.527 2.527 0 0 1 2.521 2.52v6.313A2.527 2.527 0 0 1 8.834 24a2.528 2.528 0 0 1-2.521-2.52v-6.315zm8.834-5.042a2.528 2.528 0 0 1 2.521-2.521 2.528 2.528 0 0 1 2.521 2.522v2.52h-2.522a2.528 2.528 0 0 1-2.52-2.521zm0-6.313a2.528 2.528 0 0 1 2.521 2.521 2.528 2.528 0 0 1-2.521 2.521H8.834a2.528 2.528 0 0 1-2.521-2.521V3.81a2.528 2.528 0 0 1 2.521-2.521zm-5.042 6.313a2.528 2.528 0 0 1-2.521 2.521H2.522A2.528 2.528 0 0 1 0 10.123a2.528 2.528 0 0 1 2.522-2.521h2.52v2.52zm5.042 0a2.528 2.528 0 0 1 2.521 2.521v2.52a2.528 2.528 0 0 1-2.521 2.522 2.528 2.528 0 0 1-2.521-2.522v-2.52zM15.165 6.313a2.528 2.528 0 0 1 2.521-2.521 2.528 2.528 0 0 1 2.522 2.521 2.527 2.527 0 0 1-2.522 2.52H15.165v-2.52zM8.834 5.042a2.528 2.528 0 0 1-2.521-2.521 2.528 2.528 0 0 1 2.521-2.521h2.521v2.521a2.528 2.528 0 0 1-2.521 2.521z" />
                                </svg>
                            </div>
                            <button role="switch" aria-checked="false"
                                class="bg-neutral-200 dark:bg-neutral-700 relative inline-flex h-6 w-11 flex-shrink-0 cursor-pointer rounded-full border-2 border-transparent transition-colors duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-neutral-600 focus:ring-offset-2">
                                <span aria-hidden="true"
                                    class="translate-x-0 pointer-events-none inline-block h-5 w-5 transform rounded-full bg-white shadow ring-0 transition duration-200 ease-in-out"></span>
                            </button>
                        </div>

                        <h3 class="text-base font-bold text-neutral-900 dark:text-white">Slack Notifications</h3>
                        <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-2 mb-4 line-clamp-2">
                            Get notified when clients view proposals or pay invoices.
                        </p>

                        <div
                            class="flex items-center gap-2 text-xs font-medium text-neutral-400 bg-neutral-100 dark:bg-neutral-700/50 px-2.5 py-1 rounded-md w-fit">
                            <span class="w-1.5 h-1.5 bg-neutral-400 rounded-full"></span> Disconnected
                        </div>
                    </div>

                </div>
            </div>


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

            {{-- DANGER ZONE --}}
            <section id="panel-danger" role="tabpanel"
                class="bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-xl overflow-hidden shadow-sm">

                <div
                    class="px-6 py-4 border-b border-neutral-200 dark:border-neutral-800 bg-neutral-50/50 dark:bg-neutral-900">
                    <h2 class="text-base font-semibold text-neutral-900 dark:text-white">Danger Zone</h2>
                    <p class="text-sm text-neutral-500 dark:text-neutral-400">Manage data export and account deletion.
                    </p>
                </div>

                <div class="p-6 space-y-8">

                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-sm font-medium text-neutral-900 dark:text-white">Export Data</h3>
                            <p class="text-sm text-neutral-500 dark:text-neutral-400 mt-1 max-w-lg">
                                Download a copy of your personal data, including projects and invoices, in JSON format
                                (GDPR Compliant).
                            </p>
                        </div>
                        <form action="#" method="POST" class="flex-shrink-0">
                            <button type="button"
                                class="inline-flex items-center justify-center px-4 py-2 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-lg shadow-sm text-sm font-medium text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-neutral-500 transition-all">
                                <svg class="w-4 h-4 mr-2 text-neutral-500" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4-4m0 0l-4 4m4-4v12" />
                                </svg>
                                Export Data
                            </button>
                        </form>
                    </div>

                    <div class="border-t border-neutral-100 dark:border-neutral-800"></div>

                    <div
                        class="rounded-lg border border-red-200 dark:border-red-900/50 bg-red-50 dark:bg-red-900/10 p-5">
                        <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                            <div>
                                <h3 class="text-sm font-bold text-red-700 dark:text-red-400">Delete Account</h3>
                                <p class="text-sm text-red-600/80 dark:text-red-300/70 mt-1 max-w-xl">
                                    This action is permanent and cannot be undone. All your projects, client data, and
                                    invoices will be permanently erased.
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <button data-modal-open="delete-account"
                                    class="inline-flex items-center justify-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all">
                                    <svg class="w-4 h-4 mr-2 text-red-100" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete Account
                                </button>
                            </div>
                        </div>
                    </div>

                </div>
            </section>

        </section>
    </div>



    <script>
        function themeSwitcher() {
            return {
                theme: localStorage.getItem('theme') || 'system',

                initTheme() {
                    this.applyTheme(this.theme);

                    // Watch for system changes if 'system' is selected
                    window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', e => {
                        if (this.theme === 'system') {
                            this.applyTheme('system');
                        }
                    });
                },

                setTheme(val) {
                    this.theme = val;
                    localStorage.setItem('theme', val);
                    this.applyTheme(val);
                },

                applyTheme(val) {
                    const isDark = val === 'dark' || (val === 'system' && window.matchMedia('(prefers-color-scheme: dark)')
                        .matches);

                    if (isDark) {
                        document.documentElement.classList.add('dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                    }
                }
            }
        }
    </script>
</div>
