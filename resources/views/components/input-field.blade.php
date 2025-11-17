@props(['type' => 'text', 'model' => ''])

<input type="{{ $type }}" @if ($model) wire:model="{{ $model }}" @endif
    {{ $attributes->merge([
        'class' =>
            'w-full rounded-md border border-stone-300 dark:border-neutral-700 bg-white dark:bg-neutral-900 text-gray-800 dark:text-neutral-100 px-3 py-2 focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 placeholder:text-gray-400 dark:placeholder:text-neutral-500 transition-all duration-150',
    ]) }} />
