<div class="flex items-center justify-end gap-2">
    {{-- View Action: Subtle / Neutral --}}
    <flux:tooltip content="View details">
        <flux:modal.trigger name="view-client-modal">
            <flux:button variant="ghost" size="sm" icon="eye"
                wire:click="$dispatch('view-client',{ id: {{ $row->id }} })"
                class="!h-8 !w-8 !rounded-lg text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-white/10 transition-all duration-200" />
        </flux:modal.trigger>
    </flux:tooltip>

    {{-- Edit Action: Higher Affinity --}}
    <flux:tooltip content="Edit client">
        <flux:modal.trigger name="edit-client-modal">
            <flux:button variant="ghost" size="sm" icon="pencil"
                wire:click="$dispatch('edit-client',{ id: {{ $row->id }} })"
                class="!h-8 !w-8 !rounded-lg text-zinc-500 hover:text-zinc-900 hover:bg-zinc-100 dark:text-zinc-400 dark:hover:text-white dark:hover:bg-white/10 transition-all duration-200" />
        </flux:modal.trigger>
    </flux:tooltip>
</div>
