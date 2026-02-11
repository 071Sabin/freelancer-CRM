<div class="flex items-center gap-1">
    <flux:button variant="ghost" size="sm" wire:click="downloadPdf({{ $row->id }})"
        wire:loading.attr="disabled" wire:loading.class="opacity-50 cursor-not-allowed"
        class="text-zinc-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200">
        {{-- Loading Spinner --}}
        <div wire:loading wire:target="downloadPdf({{ $row->id }})">
            <svg class="animate-spin h-4 w-4 text-zinc-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        {{-- Default Icon --}}
        <div wire:loading.remove wire:target="downloadPdf({{ $row->id }})">
            <flux:icon name="arrow-down-tray" class="size-4" />
        </div>
    </flux:button>

    <flux:modal.trigger name="view-invoice-modal">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-invoice', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200" />
    </flux:modal.trigger>

    <flux:modal.trigger name="edit-invoice-modal">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-invoice', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200" />
    </flux:modal.trigger>
</div>
