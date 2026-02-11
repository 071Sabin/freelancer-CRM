<div class="flex items-center gap-1">
    <flux:modal.trigger name="view-project-modal">
        <flux:button variant="ghost" size="sm" icon="eye"
            wire:click="$dispatch('view-project', { id: {{ $row->id }} })"
            class="text-red-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200" />
    </flux:modal.trigger>

    <flux:modal.trigger name="edit-project-modal">
        <flux:button variant="ghost" size="sm" icon="pencil"
            wire:click="$dispatch('edit-project', { id: {{ $row->id }} })"
            class="text-zinc-400 hover:text-zinc-800 dark:text-zinc-500 dark:hover:text-zinc-200 transition-colors duration-200" />
    </flux:modal.trigger>
</div>


