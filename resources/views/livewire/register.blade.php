<div class="w-full lg:w-1/3 my-5 bg-stone-50 dark:bg-stone-900 shadow-lg rounded-lg p-8">
    {{-- Success Message --}}
    @if (session('success'))
        <div
            class="mb-4 text-green-700 bg-green-100 dark:bg-green-800 dark:text-green-200 border border-green-300 dark:border-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="text-3xl font-semibold text-stone-800 dark:text-stone-100 mb-8 text-center">
        Register
    </h2>

    <form wire:submit="registerUser" class="space-y-5">

        {{-- Name --}}
        <div>
            <input type="text" wire:model.defer="name" placeholder="Full Name" required
                class="w-full p-3 rounded border border-stone-300 dark:border-stone-700 bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-200 focus:ring-stone-500 focus:border-stone-500">
            @error('name')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Email --}}
        <div>
            <input type="email" wire:model.live.debounce.700ms="email" placeholder="Email Address" required
                class="w-full p-3 rounded border border-stone-300 dark:border-stone-700 bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-200 focus:ring-stone-500 focus:border-stone-500">
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror

            <div wire:loading wire:target="email" class="text-xs text-stone-500 dark:text-stone-400 mt-1">
                Checking Email....
            </div>
        </div>

        {{-- Password --}}
        <div>
            <input type="password" wire:model.defer="password" placeholder="Password" required
                class="w-full p-3 rounded border border-stone-300 dark:border-stone-700 bg-stone-100 dark:bg-stone-800 text-stone-800 dark:text-stone-200 focus:ring-stone-500 focus:border-stone-500">
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Register Button --}}
        <button type="submit"
            class="w-full py-3 rounded bg-stone-700 text-stone-100 hover:bg-stone-800 transition-colors font-medium">
            Create account
        </button>
    </form>

    {{-- Login Link --}}
    <p class="text-center text-sm text-stone-600 dark:text-stone-400 mt-6">
        Already registered?
        <a href="{{ route('login') }}" wire:navigate
            class="text-stone-700 dark:text-stone-200 underline hover:opacity-70">
            Login
        </a>
    </p>

</div>
