<div class="flex items-center gap-1">
    <flux:button variant="ghost" size="sm" wire:click="downloadPdf({{ $row->id }})" wire:loading.attr="disabled"
        wire:loading.class="opacity-50 cursor-not-allowed"
        class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200">
        {{-- Loading Spinner --}}
        <div wire:loading wire:target="downloadPdf({{ $row->id }})">
            <svg class="animate-spin h-4 w-4 text-neutral-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
        </div>

        {{-- Default Icon --}}
        <div wire:loading.remove wire:target="downloadPdf({{ $row->id }})">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
            </svg>
        </div>
    </flux:button>

    <flux:modal.trigger name="view-invoice-modal">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-invoice', { id: {{ $row->id }} })"
            class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200" />
    </flux:modal.trigger>

    <flux:modal.trigger name="edit-invoice-modal">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-invoice', { id: {{ $row->id }} })"
            class="text-neutral-400 hover:text-neutral-800 dark:text-neutral-500 dark:hover:text-neutral-200 transition-colors duration-200" />
    </flux:modal.trigger>
</div>
