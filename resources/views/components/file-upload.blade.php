@props([
    'model' => null, // Livewire model name
    'name' => null, // HTML name fallback
    'id' => 'image-upload',
    'label' => 'Upload Image',
])

<div class="w-full">
    <label for="{{ $id }}" class="block text-sm font-medium text-gray-700 dark:text-neutral-300 mb-2">
        {{ $label }}
    </label>

    <input id="{{ $id }}" type="file" accept="image/*"
        @if ($model) wire:model="{{ $model }}" @endif name="{{ $name ?? ($model ?? $id) }}"
        {{ $attributes->merge([
            'class' => 'w-full rounded-md border border-stone-300 dark:border-neutral-700
                         bg-white dark:bg-neutral-900
                         text-gray-800 dark:text-neutral-100
                         px-3 py-2
                         file:mr-4 file:py-2 file:px-4
                         file:rounded-md file:border-0
                         file:bg-stone-100 dark:file:bg-neutral-700
                         file:text-gray-700 dark:file:text-neutral-100
                         focus:outline-none focus:ring-2 focus:ring-blue-500
                         placeholder:text-gray-400 dark:placeholder:text-neutral-500
                         transition-all duration-150',
        ]) }} />

    {{-- For Livewire validation errors --}}
    {{ $slot }}
</div>
