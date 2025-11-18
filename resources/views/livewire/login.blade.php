<div class="w-full lg:w-1/3 bg-neutral-50 dark:bg-neutral-900 shadow-lg rounded-lg p-8 my-5">

    <h2 class="text-3xl font-semibold text-center text-neutral-800 dark:text-neutral-100 mb-8">
        Login
    </h2>

    {{-- Error Alert --}}
    @error('loginError')
        <div
            class="mb-4 text-red-700 bg-red-100 dark:bg-red-900 dark:text-red-200 border border-red-300 dark:border-red-700 p-3 rounded">
            {{ $message }}
        </div>
    @enderror

    {{-- Success Alert --}}
    @if (session('success'))
        <div
            class="mb-4 text-green-700 bg-green-100 dark:bg-green-800 dark:text-green-200 border border-green-300 dark:border-green-700 p-3 rounded">
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <form wire:submit="useAuthentication" class="space-y-5">
        @csrf

        {{-- Email --}}
        <div>
            <label class="block mb-1 text-neutral-700 dark:text-neutral-300 text-sm font-medium">Email</label>
            <input type="email" wire:model="email"
                class="w-full p-3 rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800
                              text-neutral-800 dark:text-neutral-100 focus:ring-neutral-500 focus:border-neutral-500"
                required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block mb-1 text-neutral-700 dark:text-neutral-300 text-sm font-medium">Password</label>
            <input type="password" wire:model.defer="password"
                class="w-full p-3 rounded border border-neutral-300 dark:border-neutral-700 bg-neutral-100 dark:bg-neutral-800
                              text-neutral-800 dark:text-neutral-100 focus:ring-neutral-500 focus:border-neutral-500"
                required>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Login Button --}}
        <button type="submit"
            class="w-full py-3 font-medium text-neutral-100 bg-neutral-700 hover:bg-neutral-800 rounded transition-colors">
            Login
        </button>
    </form>

    {{-- Forgot Password --}}
    <p class="text-center text-sm text-neutral-600 dark:text-neutral-400 mt-6">
        Forgot password?
        <a href="#" class="text-neutral-700 dark:text-neutral-200 underline hover:opacity-70">Reset Here</a>
    </p>
    <p class="text-center text-sm text-neutral-600 dark:text-neutral-400 mt-6">
        New Here?
        <a href="{{ route('register') }}" class="text-neutral-700 dark:text-neutral-200 underline hover:opacity-70"
            wire:navigate>Register</a>
    </p>
</div>
