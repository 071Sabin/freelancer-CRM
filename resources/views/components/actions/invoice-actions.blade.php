<div class="flex items-center gap-1">
    <flux:button variant="ghost" size="sm" icon="arrow-down-tray" wire:click="downloadPdf({{ $row->id }})"
        class="text-zinc-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200" />

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
