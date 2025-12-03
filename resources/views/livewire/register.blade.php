<div class="w-full lg:w-1/3 my-5 bg-neutral-50 dark:bg-neutral-900 shadow-lg rounded-lg p-8">
    {{-- Success Message --}}
    @if (session('success'))
        <div
            class="mb-4 text-green-700 bg-green-100 dark:bg-green-800 dark:text-green-200 border border-green-300 dark:border-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-3xl font-semibold text-neutral-800 dark:text-neutral-100 mb-8 text-center">
        Register
    </h2>

    <form wire:submit="registerUser" class="space-y-5">

        {{-- Name --}}
        <div>
            <input type="text" wire:model.defer="name" placeholder="Full Name" required
                class="w-full p-3 rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 focus:ring-neutral-500 focus:border-neutral-500">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <input type="email" wire:model.live.debounce.700ms="email" placeholder="Email Address" required
                class="w-full p-3 rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 focus:ring-neutral-500 focus:border-neutral-500">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div wire:loading wire:target="email" class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                Checking Email....
            </div>
        </div>

        {{-- Password --}}
        <div>
            <input type="password" wire:model="password" placeholder="Password" required
                class="w-full p-3 rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 focus:ring-neutral-500 focus:border-neutral-500">
            <input type="password" wire:model="password_confirmation" placeholder="Confirm Password" required
                class="w-full mt-3 p-3 rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800 text-neutral-800 dark:text-neutral-200 focus:ring-neutral-500 focus:border-neutral-500">

            <div wire:loading wire:target="password_confirmation"
                class="text-xs text-neutral-500 dark:text-neutral-400 mt-1">
                Checking password....
            </div>

            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Register Button --}}
        <button type="submit"
            class="w-full py-3 rounded bg-neutral-700 text-neutral-100 hover:bg-neutral-800 transition-colors font-medium">
            Create account
        </button>
    </form>

    {{-- Login Link --}}
    <p class="text-center text-sm text-neutral-600 dark:text-neutral-400 mt-6">
        Already registered?
        <a href="{{ route('login') }}" wire:navigate
            class="text-neutral-700 dark:text-neutral-200 underline hover:opacity-70">
            Login
        </a>
    </p>

</div>
