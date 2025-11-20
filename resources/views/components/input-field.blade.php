@props(['type' => 'text', 'model' => '', 'placeholder' => '', 'label' => '', 'required' => false])

<div>
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
</div>
