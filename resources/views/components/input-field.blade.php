@props(['type' => 'text', 'model' => '', 'placeholder' => '', 'label' => '', 'required' => false])

{{-- <div>
    <label>
        <span class="text-neutral-600 font-semibold dark:text-neutral-400 text-sm">{{ $label }}</span>
        @if ($required)
            <span class="text-red-500">*</span>
        @endif
    </label>
    <input type="{{ $type }}" @if ($model) wire:model="{{ $model }}" @endif
        placeholder="{{ $placeholder }}"
        {{ $attributes->merge([
            'class' =>
                'w-full rounded-md border border-neutral-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-neutral-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150',
        ]) }} />
</div> --}}


<div class="w-full group">

    <label @if ($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif
        class="block text-xs md:text-sm font-medium leading-6 text-neutral-900 dark:text-neutral-400 transition-colors duration-200">
        {{ $label }}
        @if ($required ?? false)
            <span class="text-red-500 font-bold ml-0.5" title="Required">*</span>
        @endif
    </label>

    <div class="mt-2 relative">
        <input type="{{ $type ?? 'text' }}" @if ($model ?? false) wire:model="{{ $model }}" @endif
            placeholder="{{ $placeholder ?? '' }}"
            {{ $attributes->merge([
                'class' => '
                                block w-full rounded-lg border-0 
                                py-2.5 px-3 
                                text-neutral-900 dark:text-white 
                                bg-white dark:bg-neutral-900 
                                shadow-sm 
                                ring-1 ring-inset ring-neutral-300 dark:ring-neutral-700 
                                placeholder:text-neutral-400 dark:placeholder:text-neutral-500 
                                focus:ring-2 focus:ring-inset focus:ring-indigo-600 dark:focus:ring-indigo-500 
                                text-sm md:text-base leading-6 
                                transition-shadow duration-200 ease-in-out
                                disabled:cursor-not-allowed disabled:bg-neutral-50 disabled:text-neutral-500 disabled:ring-neutral-200
                            ',
            ]) }} />

        @if ($model)
            @error($model)
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center pr-3">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd"
                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-5a.75.75 0 01.75.75v4.5a.75.75 0 01-1.5 0v-4.5A.75.75 0 0110 5zm0 10a1 1 0 100-2 1 1 0 000 2z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
            @enderror
        @endif
    </div>

    @if ($model)
        @error($model)
            <p class="mt-2 text-xs text-red-600 dark:text-red-400 animate-pulse">
                {{ $message }}
            </p>
        @enderror
    @endif

</div>
