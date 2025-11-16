<div class="w-full lg:w-1/3 bg-stone-50 dark:bg-stone-900 shadow-lg rounded-lg p-8 my-5">

    <h2 class="text-3xl font-semibold text-center text-stone-800 dark:text-stone-100 mb-8">
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
            <label class="block mb-1 text-stone-700 dark:text-stone-300 text-sm font-medium">Email</label>
            <input type="email" wire:model="email"
                class="w-full p-3 rounded border border-stone-300 dark:border-stone-700 bg-stone-100 dark:bg-stone-800
                              text-stone-800 dark:text-stone-100 focus:ring-stone-500 focus:border-stone-500"
                required>
            @error('email')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Password --}}
        <div>
            <label class="block mb-1 text-stone-700 dark:text-stone-300 text-sm font-medium">Password</label>
            <input type="password" wire:model.defer="password"
                class="w-full p-3 rounded border border-stone-300 dark:border-stone-700 bg-stone-100 dark:bg-stone-800
                              text-stone-800 dark:text-stone-100 focus:ring-stone-500 focus:border-stone-500"
                required>
            @error('password')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Login Button --}}
        <button type="submit"
            class="w-full py-3 font-medium text-stone-100 bg-stone-700 hover:bg-stone-800 rounded transition-colors">
            Login
        </button>
    </form>

    {{-- Forgot Password --}}
    <p class="text-center text-sm text-stone-600 dark:text-stone-400 mt-6">
        Forgot password?
        <a href="#" class="text-stone-700 dark:text-stone-200 underline hover:opacity-70">Reset Here</a>
    </p>
    <p class="text-center text-sm text-stone-600 dark:text-stone-400 mt-6">
        New Here?
        <a href="{{ route('register') }}" class="text-stone-700 dark:text-stone-200 underline hover:opacity-70" wire:navigate>Register</a>
    </p>
</div>
