@props(['type' => 'text', 'model' => '', 'placeholder' => '', 'label' => '', 'required' => false])


<div class="w-full group">

    <label @if ($attributes->has('id')) for="{{ $attributes->get('id') }}" @endif
        class="block text-sm font-medium leading-6 text-neutral-900 transition-colors duration-200 dark:text-neutral-300">
        {{ $label }}
        @if ($required ?? false)
            <span class="ml-0.5 font-bold text-red-500" title="Required">*</span>
        @endif
    </label>

    <div class="relative">
        <input type="{{ $type ?? 'text' }}" @if ($model ?? false) wire:model="{{ $model }}" @endif
            placeholder="{{ $placeholder ?? '' }}"
            {{ $attributes->merge([
                'class' => '
                                block w-full rounded-lg border-0 py-2 px-3 sm:text-sm leading-6 
                                text-neutral-900 bg-white mt-2.5 shadow-xs
                                ring-1 ring-inset ring-neutral-300 placeholder-neutral-400 
                                focus:ring-1 focus:ring-inset focus:ring-indigo-600 
                                transition-shadow duration-200 ease-in-out dark:border-neutral-600 dark:border-1 dark:border-neutral-50
                                disabled:cursor-not-allowed disabled:bg-neutral-50 disabled:text-neutral-500 disabled:ring-neutral-200 
                                dark:bg-white/10 dark:text-white dark:ring-neutral-700 dark:placeholder-neutral-400 dark:focus:ring-indigo-500
                            ',
            ]) }} />

        @if ($model)
            @error($model)
                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                    <svg class="w-5 h-5 text-red-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
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
            <p class="mt-2 text-xs text-red-600 dark:text-red-400">
                {{ $message }}
            </p>
        @enderror
    @endif

</div>
