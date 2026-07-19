<div>
    @if (session('success'))
        <x-notification type="success">{{ session('success') }}</x-notification>
    @endif
    @if (session('error'))
        <x-notification type="error">{{ session('error') }}</x-notification>
    @endif
    <x-main-heading title="Profile Settings" subtitle="Update name, email, bio and avatar." />
    <x-error></x-error>

    <div class="mt-6 bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 rounded-2xl overflow-hidden">
        <form wire:submit="updateInfo" enctype="multipart/form-data">
            
            <div class="p-6 sm:p-8 grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
                
                <!-- Left: Form fields -->
                <div class="lg:col-span-8 space-y-6">
                    <div>
                        <h3 class="text-base font-semibold leading-6 text-neutral-900 dark:text-white">Personal Information</h3>
                        <p class="mt-1 text-sm text-neutral-500 dark:text-neutral-400">Review and update your personal details and public profile.</p>
                    </div>

                    <div class="space-y-5">
                        <div>
                            <x-input-field type="text" model="name" label="Full Name" required />
                        </div>

                        <div>
                            <x-input-field type="email" model="email" readonly
                                class="bg-neutral-50 dark:bg-neutral-800/50 text-neutral-500 cursor-not-allowed" label="Email Address" />
                        </div>

                        <div>
                            <div class="flex justify-between mb-1.5">
                                <label class="text-sm font-medium text-neutral-700 dark:text-neutral-300">Bio</label>
                                <span class="text-xs text-neutral-500">Optional</span>
                            </div>
                            <flux:textarea wire:model="bio" placeholder="Write a few sentences about yourself...">
                                {{ Auth::guard('web')->user()->bio ?? '' }}</flux:textarea>
                        </div>
                    </div>
                </div>

                <!-- Right: Avatar -->
                <div class="lg:col-span-4 flex flex-col items-center justify-start lg:pt-12">
                    <div class="w-full max-w-sm rounded-xl border border-neutral-200/80 dark:border-neutral-800/80 bg-neutral-50/50 dark:bg-neutral-900/50 p-6 flex flex-col items-center text-center">
                        <h4 class="text-sm font-semibold text-neutral-700 dark:text-neutral-300 mb-4 w-full text-left">Profile Picture</h4>
                        
                        <div class="relative group mb-5">
                            <div class="w-32 h-32 rounded-full ring-1 ring-neutral-200 dark:ring-neutral-700 overflow-hidden bg-white dark:bg-neutral-800 relative">
                                <div wire:loading wire:target="profile_pic"
                                    class="absolute inset-0 bg-white/60 dark:bg-black/40 backdrop-blur-sm z-50 flex items-center justify-center">
                                    <svg class="animate-spin h-6 w-6 text-indigo-600 dark:text-indigo-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                </div>
                                @if ($profile_pic)
                                    <img src="{{ $profile_pic->temporaryUrl() }}" class="w-full h-full object-cover">
                                @elseif(Auth::guard('web')->user()->profile_pic)
                                    <img src="{{ asset('uploads/' . Auth::guard('web')->user()->profile_pic) }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-neutral-100 dark:bg-neutral-800 text-neutral-400">
                                        <svg class="h-14 w-14" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <span class="absolute bottom-2 right-2 h-4 w-4 rounded-full ring-2 ring-white dark:ring-neutral-900 bg-emerald-500"></span>
                        </div>

                        <div class="w-full">
                            <label for="profile_upload" class="cursor-pointer flex items-center justify-center w-full px-4 py-2 bg-white dark:bg-neutral-800 border border-neutral-300 dark:border-neutral-600 rounded-lg text-sm font-medium text-neutral-700 dark:text-neutral-200 hover:bg-neutral-50 dark:hover:bg-neutral-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path>
                                </svg>
                                Upload Photo
                            </label>
                            <input type="file" id="profile_upload" wire:model="profile_pic" class="hidden" accept="image/png, image/jpeg">
                        </div>
                        <p class="mt-3 text-xs text-neutral-500">JPG or PNG. Max 2MB.</p>
                        @error('profile_pic')
                            <p class="text-xs text-red-500 mt-2 bg-red-50 dark:bg-red-900/20 px-2 py-1 rounded">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Footer: Save button -->
            <div class="px-6 py-4 bg-neutral-50/80 dark:bg-neutral-800/40 border-t border-neutral-200 dark:border-neutral-800 flex items-center justify-end">
                <x-primary-button type="submit" wire:loading.attr="disabled" class="px-6 py-2.5">
                    <svg wire:loading wire:target="updateInfo" class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Save Changes
                </x-primary-button>
            </div>
        </form>
    </div>
</div>
